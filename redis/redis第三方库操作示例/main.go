package main

import (
	"fmt"
	"github.com/gomodule/redigo/redis"
)

func main(){
	//通过go向redis写入数据和读取数据
	//1.链接到redis
	//开启本地的redis服务
	conn,err:=redis.Dial("tcp","127.0.0.1:6379")
	if err !=nil{
		fmt.Println("redis.Dial err=",err)
		return
	}
	fmt.Println("conn success",conn)
	//通过go向redis写入数据string[key-val]
	ok,errs :=conn.Do("set","name","tancanghai")
	if errs !=nil{
		fmt.Println("set errs=",errs)
		return
	}
	fmt.Println("set ok=",ok)

	s,errg := redis.String(conn.Do("get","name"))
	if errg !=nil{
		fmt.Println("get errs=",errg)
		return
	}
	fmt.Println("get s=",s)
}
