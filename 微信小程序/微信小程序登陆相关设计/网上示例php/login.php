<?php

namespace app\api\controller;



class login
{
    //auth.code2Session接口获取获取session_key 和openid//然后解密数据
    //缺少返还自定义登陆态步骤
    public function get_data()
    {
        //开发者使用登陆凭证 code 获取 session_key 和 openid
        $APPID = '';//自己配置
        $AppSecret = '';//自己配置
        $code = input('code');
        //auth.code2Session接口
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $APPID . "&secret=" . $AppSecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $arr = $this->vget($url); // 一个使用curl实现的get方法请求
        $arr = json_decode($arr, true);

        //获取session_key 和openid
        $openid = $arr['openid'];
        $session_key = $arr['session_key'];
        // 数据签名校验
        $signature = input('signature');
        $rawData = Request::instance()->post('rawData');
        $signature2 = sha1($rawData . $session_key);
        if ($signature != $signature2) {
            return json(['code' => 500, 'msg' => '数据签名验证失败！']);
        }
        Vendor("PHP.wxBizDataCrypt"); //加载解密文件，在官方有下载
        $encryptedData = input('encryptedData');
        $iv = input('iv');
        $pc = new \WXBizDataCrypt($APPID, $session_key);
        $errCode = $pc->decryptData($encryptedData, $iv, $data); //其中$data包含用户的所有数据
        $data = json_decode($data);
        if ($errCode == 0) {
            dump($data);
            die;//打印解密所得的用户信息
        } else {
            echo $errCode;//打印失败信息
        }

        //可以修改为和$session_key与$openid 相关的唯一字符串类似与token的写法

//        //生成第三方3rd_session
//        $session3rd  = null;
//        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
//        $max = strlen($strPol)-1;
//        for($i=0;$i<16;$i++){
//            $session3rd .=$strPol[rand(0,$max)];
//        }
//        echo $session3rd;

    }

    public function vget($url){
        $info=curl_init();
        curl_setopt($info,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($info,CURLOPT_HEADER,0);
        curl_setopt($info,CURLOPT_NOBODY,0);
        curl_setopt($info,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($info,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($info,CURLOPT_URL,$url);
        $output= curl_exec($info);
        curl_close($info);
        return $output;
    }
}