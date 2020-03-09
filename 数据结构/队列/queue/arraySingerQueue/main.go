package main

import (
	"errors"
	"fmt"
	"os"
)

//使用一个结构体管理队列
type Queue struct {
	maxSize int    //数组最大下标的大小
	array   [5]int //数组定义
	front   int    //队列首
	rear    int    //队列的尾部
}

//添加数据到队列队列
func (this *Queue) AddQueue(val int) (err error) {
	//先判断列队是否已满
	if this.rear == this.maxSize-1 { //rear是队列尾部并且包含最后元素
		return errors.New("queue full")
	}
	this.rear++ //rear 后移一位
	this.array[this.rear] = val
	return
}

//从列队中取出数据
func(this *Queue) GetQueue()(val int,err error){
	//先判断列队是否为空
	if this.rear ==this.front{ //队空
		return -1,errors.New("queue empty")
	}
	this.front++
	val=this.array[this.front]
	return  val ,err
}

//显示队列 ,找到队首，然后遍历到队尾
func (this *Queue) ShowQueue() {
	fmt.Println("队列的当前情况是：")
	//this.front 不包含队首的元素
	for i := this.front + 1; i <= this.rear; i++ {
		fmt.Printf("arrary[%d]=%d\t", i, this.array[i])
	}
	fmt.Println("")
}

//测试函数
func main() {
	//先创建一个队列
	queue := &Queue{
		maxSize: 5,  //数组最大下标的大小
		front:   -1, //队列首
		rear:    -1,
	}
	var key string
	var val int
	//添加数
	for {
		fmt.Println("1.输入add  表示添加数据到队列")
		fmt.Println("2.输入get  表示从队列中获取数据")
		fmt.Println("3.输入show  表示显示队列")
		fmt.Println("4.输入exit  表示退出")

		fmt.Scanln(&key)
		switch key {
		case "add":
			fmt.Println("请输入你要入队列的数据")
			fmt.Scanln(&val)
			err := queue.AddQueue(val)
			if err != nil {
				fmt.Println("失败！原因：", err.Error())
			} else {
				fmt.Println("加入队列ok")
			}
		case "get":
			val,err:= queue.GetQueue()
			if err !=nil{
				fmt.Println("取数据错误：",err.Error())
			}else{
				fmt.Println("从队列中取出一个数=",val)
			}
		case "show":
			queue.ShowQueue()
		case "exit":
			os.Exit(0)
		}
	}
}
