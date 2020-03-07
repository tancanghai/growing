package main

import (
	"bufio"
	"fmt"
	"net"
	"os"
)

func main(){
	conn, err := net.Dial("tcp", "192.168.124.9:18888")
	if err != nil {
		fmt.Printf("连接失败！")
	}
	fmt.Printf("连接成功！")
	fmt.Fprintf(conn, "GET / HTTP/1.0\r\n\r\n")
	//status, err := bufio.NewReader(conn).ReadString('\n')
	//功能一：客户端可以发送单行数据，然后就退出
	reader :=bufio.NewReader(os.Stdin)//os.Stdin 代表标准输入【终端】
	//从终端读取一行用户输入，并准备发送给服务器
	line ,err :=reader.ReadString('\n')
	if err!=nil{
		fmt.Println("readString err=" ,err)
	}
	//再将line发送给服务器
	n,err :=conn.Write([]byte(line))
	if err!=nil{
		fmt.Println("conn.Write err=" ,err)
	}
	fmt.Printf("客户端发送了%d字节的数据，并退出",n)
}

