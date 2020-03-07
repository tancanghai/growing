package main

import (
	"fmt"
	"net"//网络socket开发时，net包含有我们需要所有的方法和函数
)

func  main()  {
	Listener, err := net.Listen("tcp", "0.0.0.0:18888")
	//返回在一个本地网络地址laddr上监听的Listener接口，等于开启一个端口
	//Listener是一个用于面向流的网络协议的公用的网络监听器接口
	if err !=nil {
		fmt.Printf("err=%v",err)
	}
		fmt.Printf("Listener=%v",Listener)
	defer Listener.Close()

	Addr := Listener.Addr()
	fmt.Println("该接口的监听的网络地址=",Addr)
	for{//循环等待客户连接端口//使用telnet www.baidu.com 80  来测试是否连接端口
		//多个线程可能会同时调用一个Listener的方法
		conn,err := Listener.Accept()
		if err !=nil {
			fmt.Println("客户端连接到该网络监听器接口的连接失败！")
		}
		fmt.Println("客户端连接到该网络监听器接口的连接成功！")
		go func() {
			defer conn.Close()
			Addr :=conn.LocalAddr()
			fmt.Printf("客户端连接返回连接本地网络地址Addr=%v",Addr)
		}()

	}
}
