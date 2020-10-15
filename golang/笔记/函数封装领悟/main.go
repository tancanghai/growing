package main

import (
	"encoding/base64"
	"encoding/json"
	"errors"
	"flag"
	"github.com/souriki/ali_mns"
	"time"
)

var (
	Env             string
	mns_client      ali_mns.MNSClient
	sqlstr    		string
	queues          map[string]ali_mns.AliMNSQueue
)

//ApiMessage 数据
type ApiMessage struct {
	SvrCode    string
	EvtCode    string
	EvtName    string
	EvtScope   string
	EvtSource  string
	EvtTime    int64
	EvtContent map[string]interface{}
}

func init() {
	sqlstr="SELECT api_code,queue_name_origin,queue_name_target FROM `oauth_api_queue_name` where state=1 and subscribe_flag=1"
	flag.StringVar(&Env, "env", "testing", "指定运行环境")
	flag.Parse()
	log.Debugf("Env is [%s]\n", Env)
	InitLog()
	NewConfig()
	//初始 mnsclient
	mns_client = ali_mns.NewAliMNSClient(Ya.Aliyun.EndPoint, Ya.Aliyun.AccessKeyId, Ya.Aliyun.AccessKeySecret)
	log.Debug("已初始化 mns-client...")
	db = GetMysqlConn()

	queues = make(map[string]ali_mns.AliMNSQueue)
}

func main() {
	data, error := fetchRows(db, sqlstr)
	if error != nil {
		log.Error(error)
		return
	}
	// 可通过调用ticker.Stop取消
	t := time.NewTicker(time.Minute * 5)
	defer t.Stop()
	go func() {
		for {
			log.Debug("判定数据库间隔5Minute获取数据")
			<-t.C
			data1, error := fetchRows(db, sqlstr)
			if error != nil {
				log.Error(error)
				return
			}
			data = data1
			log.Debug("Ticker running...")
		}
	}()
	go func() {
		//for {
			time.Sleep(time.Second * 1)
			var queueData = map[string][]string{}
			var queueNameOriginDatas = map[string]string{}
			log.Debug("data==.................")
			for k, v := range *data { //得到拼接的数据
				log.Debug(k, v)
				queueData[v["queue_name_origin"]+v["api_code"]] = append(queueData[v["queue_name_origin"]+v["api_code"]], v["queue_name_target"])
				queueNameOriginDatas[v["queue_name_origin"]] = ""
			}
			log.Debugf("queueData=%v", queueData)
			log.Debugf("queueNameOriginDatas=%v", queueNameOriginDatas)

			for QueueName, _ := range queueNameOriginDatas { //多个携程去时时去取queue_name_origin队列里面的数据
				go startConsumer(QueueName, queueData)
			}
		//}
	}()
	select {}
}

//从scrm队列中取数据
func startConsumer(QueueName string, queueData map[string][]string) {
	defer func() {
		if err := recover(); err != nil {
			log.Errorf(" 异常抛出===>:%v", err)
		} else {
			log.Debug(" 流程正常结束")
		}
	}()

	log.Debugf("QueueName: %v", QueueName)
	//获取队列体

	queue, ok := queues[QueueName];
	if !ok {
		log.Debugf("======new startConsumer=====:%v", QueueName)
		queue = ali_mns.NewMNSQueue(QueueName, mns_client)
		queues[QueueName] = queue
	}

	endChan := make(chan int)
	//接收信息的反馈文
	batchRespChan := make(chan ali_mns.BatchMessageReceiveResponse)
	errChan := make(chan error)

	go func() {
		for {
			var receiptHandles []string

			select {
			case resp := <-batchRespChan:
				{
					for _, respMess := range resp.Messages {
						decodeBytes, err := base64.StdEncoding.DecodeString(respMess.MessageBody)
						if err != nil {
							log.Errorf("接收aliyun消息错误：%v", err)
						}
						decodestrs := string(decodeBytes)
						log.Debugf("从队列： %+v 获取的数据decodeBytes: %+v", QueueName,decodestrs)

						//处理doHanlder()
						doerr := doHanlder(decodestrs, queueData, QueueName)
						if doerr != nil {
							log.Debugf("doHanlder() error=%+v", doerr)
						}

						//获取ali queue handles
						receiptHandles = append(receiptHandles, respMess.ReceiptHandle)
					}

					//批量删除队列多条消息
					if _, e := queue.BatchDeleteMessage(receiptHandles...); e != nil {
						log.Debug("delete message fail")
					} else {
						log.Debug("delete message success")
					}

					endChan <- 1
				}
			case err := <-errChan:
				{
					log.Errorf("%v", err)
					endChan <- 1
				}
			}
		}
	}()

	for {
		queue.BatchReceiveMessage(batchRespChan, errChan, 16, 30)
		<-endChan
	}
}

// 处理函数
func doHanlder(decodestrs string, queueData map[string][]string, QueueName string) error {
	//信息内容
	err, msgdatas := SdataToMige(decodestrs)
	if err != nil {
		log.Errorf("将 队列： %+v 获取的数据转换成需要的形式 error: %v",QueueName, err)
		return err
	}
	//把信息内容转换成json
	jsonByte, err := json.Marshal(msgdatas)
	if err != nil {
		log.Errorf("SendQueueMes json.Marshal error: %v", err)
		return err
	}
	//信息内容base64加密
	encodeBytes := base64.StdEncoding.EncodeToString(jsonByte)
	var errSendQueueMes error
	//发送到队列去队列去
	v,ok:=queueData[QueueName+msgdatas.EvtCode]
	if ok {
		for _,value :=range v{
			errSendQueueMes = SendQueueMes(value, encodeBytes)
			if errSendQueueMes == nil {
				log.Debugf("%v==>send ok!", value)
				log.Debugf("发送给队列%+v的数据为：%+v",value, string(jsonByte))
			}
		}
		return nil
	}
	return errSendQueueMes
}

// 发送给队列消息
func SendQueueMes(queueName string, encodeBytes string) error {
	//获取队列体
	//queue := ali_mns.NewMNSQueue(queueName, mns_client)

	queue, ok := queues[queueName];
	if !ok {
		log.Debugf("======new SendQueueMes=====:%v", queueName)
		queue = ali_mns.NewMNSQueue(queueName, mns_client)
		queues[queueName] = queue
	}

	//发送的信息属性
	msg := ali_mns.MessageSendRequest{
		MessageBody:  encodeBytes,
		DelaySeconds: 0,
		Priority:     8,
	}
	//发送给队列信息
	_, err := queue.SendMessage(msg)
	if err != nil {
		log.Debugf("错误！没发送数据给队列%+v",queueName)
		log.Errorf("Aliyun queue SendMessage error: %v", err)
		return err
	}
	return nil
}

//将 和联盟 传过来的数据转换成 米格 需要的形式
func SdataToMige(data string) (error, ApiMessage) {
	//ScanStatusHas := true
	var err error
	var changeLogData ApiMessage

	msgs := []byte(data)
	//将获取到的数据转成结构体
	var logData ApiMessage
	if err = json.Unmarshal(msgs, &logData); err != nil {
		return err, changeLogData
	}
	//log.Debugf("%v",logData)
	//再从结构体中把 需要的数据取出来 放入新的结构体中
	changeLogData.SvrCode = logData.SvrCode
	changeLogData.EvtCode = logData.EvtCode
	changeLogData.EvtName = logData.EvtName
	changeLogData.EvtScope = logData.EvtScope
	changeLogData.EvtSource = "hlmclient"
	changeLogData.EvtTime = logData.EvtTime
	changeLogData.EvtContent = map[string]interface{}{}
	ExtenalData := logData.EvtContent["ExtenalData"]
	NotifyBusiness, ok := logData.EvtContent["NotifyBusiness"].(string)
	if ok {
		changeLogData.EvtContent["NotifyBusiness"] = NotifyBusiness
	} else {
		err := errors.New("logData.EvtContent[\"NotifyBusiness\"].(string)  失败！")
		return err, changeLogData
	}
	if NotifyBusiness == "SCAN" {
		changeLogData.EvtContent["ScanMsg"] = logData.EvtContent["ScanMsg"]
		ScanStatus, ok := logData.EvtContent["ScanStatus"].(float64)
		if ok {
			changeLogData.EvtContent["ScanStatus"] = ScanStatus
		} else {
			err := errors.New("logData.EvtContent[\"ScanStatus\"].(int)  失败！")
			return err, changeLogData
		}
	} else {
		changeLogData.EvtContent["Status"] = logData.EvtContent["Status"]
	}
	value, ok := ExtenalData.(map[string]interface{})
	if ok {
		changeLogData.EvtContent["ShopUuid"] = value["ShopUuid"]
	} else {
		err := errors.New("ExtenalData.(map[string]interface{})  失败！")
		return err, changeLogData
	}
	changeLogData.EvtContent["ShopName"] = logData.EvtContent["ShopName"]
	changeLogData.EvtContent["UserName"] = logData.EvtContent["UserName"]
	changeLogData.EvtContent["ExecutorUuid"] = logData.EvtContent["ExecutorUuid"]
	changeLogData.EvtContent["MaterialNum"] = logData.EvtContent["MaterialNum"]
	changeLogData.EvtContent["IsAward"] = logData.EvtContent["IsAward"]
	changeLogData.EvtContent["Cbk"] = logData.EvtContent["Cbk"]
	changeLogData.EvtContent["UniqueLogic"] = logData.EvtContent["UniqueLogic"]
	changeLogData.EvtContent["AwardTime"] = logData.EvtContent["AwardTime"]
	changeLogData.EvtContent["MaterialName"] = logData.EvtContent["MaterialName"]
	return err, changeLogData
}
