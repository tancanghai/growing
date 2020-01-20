package main

import (
	"customer/customerservice"
	"fmt"
)

type customerview struct {
	customerservice *customerservice.CustomerServic
	key int
	loop bool
	exits string
}

func main() {
	var customerview =customerview{
	}
	fmt.Println(customerview.customerservice)
	customerview.customerservice = &customerservice.CustomerServic{}
	//不写上面一行代码可以看到，直接panic。原因就是，在调用CustomerAdd方法的时候，使用的"customerservice"并没有给他开辟空间。
	//指针的定义只有使用了"new"关键字之后，才开辟空间，否则就是nil指针，使用这个nil指针，
	//想要使用结构体的读写锁，那是不可能的！
	customerview.menu()
}

func (this customerview)menu()  {
	this.loop= false
	//this.customerservice.NewCustomerServic()
	for {
		fmt.Println("客户信息管理软件----------\n")
		fmt.Println("1  添加客户")
		fmt.Println("2  查看客户")
		fmt.Println("3  修改客户")
		fmt.Println("4  删除客户")
		fmt.Println("5  客户列表")
		fmt.Println("6  退出")
		fmt.Print("请选择（1-5）：")
		fmt.Scanln(&this.key)
		switch this.key {
		case 1:
			fmt.Println("1  添加客户")
			this.customerservice.CustomerAdd()
			break
		case 2:
			fmt.Println("2  查看客户")
			this.customerservice.CustomerCheck()
			break
		case 3:
			fmt.Println("3  修改客户")
			this.customerservice.CustomerUpdate()
			break
		case 4:
			fmt.Println("4  删除客户")
			this.customerservice.CustomerDelete()
			break
		case 5:
			fmt.Println("5  客户列表")
			this.customerservice.CustomerList()
			break
		case 6:
			fmt.Print("你确定要退出（yes/no）:\n")
			fmt.Scan(&this.exits)
			for{
				if  this.exits=="yes" || this.exits=="no"{
					if  this.exits=="yes"{
						this.loop=true
					}
					break
				}else{
					fmt.Print("选择错误，请重新输入：")
					fmt.Scan(&this.exits)
				}
			}
			break
		}
		if this.loop {
			break
		}
	}
}
