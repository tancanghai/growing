package customerservice

import (
	"customer/customermodel"
	"fmt"
)

type CustomerServic struct {
	CustomerArr []customermodel.Customer
	Totalid     int
}

func (this *CustomerServic) NewCustomerServic(CustomerArr []customermodel.Customer, Totalid int) *CustomerServic {
	var customerservic = &CustomerServic{
		CustomerArr: CustomerArr,
		Totalid:     Totalid,
	}
	return customerservic
}

func (this *CustomerServic) CustomerList() {
	fmt.Println("客户列表----------------")
	fmt.Println("编号  姓名  性别  年龄  电话    邮箱")
	for _, val := range this.CustomerArr {
		fmt.Printf("%v  %v  %v  %v    %v\n", val.Name, val.Sex, val.Old, val.Phone, val.Email)
	}
}

func (this *CustomerServic) CustomerAdd() {
	var Name string
	var Sex string
	var Old int
	var Phone string
	var Email string
	fmt.Println("添加客户----------------")
	fmt.Println("姓名：")
	fmt.Scanln(&Name)
	fmt.Println("性别：")
	fmt.Scanln(&Sex)
	fmt.Println("年龄：")
	fmt.Scanln(&Old)
	fmt.Println("电话：")
	fmt.Scanln(&Phone)
	fmt.Println("邮箱：")
	fmt.Scanln(&Email)
	this.Add(Name, Sex, Old, Phone, Email)
}

func (this *CustomerServic) Add(Name string, Sex string, Old int, Phone string, Email string) *CustomerServic {
	var Customer = customermodel.NewCustomer(Name, Sex, Old, Phone, Email)
	this.CustomerArr = append(this.CustomerArr, Customer)
	return this
}

func (this *CustomerServic) CustomerDelete() {
	var Totalid int
	fmt.Println("删除客户----------------")
	fmt.Println("请输入需要删除客户的编号：")
	fmt.Scanln(&Totalid)
	if len(this.CustomerArr) >= Totalid {
		this.CustomerArr = append(this.CustomerArr[:Totalid], this.CustomerArr[Totalid:]...)
		this.Totalid -= 1
	} else {
		fmt.Println("请输入正确的编号！")
	}
}

func (this *CustomerServic) CustomerCheck() {
	var Totalid int
	fmt.Println("查看客户----------------")
	fmt.Println("请输入需要查看客户的编号：")
	fmt.Scanln(&Totalid)
	if len(this.CustomerArr) >= Totalid {
		fmt.Println("编号  姓名  性别  年龄  电话    邮箱")
		fmt.Printf("%v  %v  %v  %v    %v\n", this.CustomerArr[Totalid].Name, this.CustomerArr[Totalid].Sex, this.CustomerArr[Totalid].Old, this.CustomerArr[Totalid].Phone, this.CustomerArr[Totalid].Email)
	} else {
		fmt.Println("请输入正确的编号！")
	}
}

func (this *CustomerServic) CustomerUpdate() {
	var Totalid int
	fmt.Println("修改客户----------------")
	fmt.Println("请输入需要修改客户的编号：")
	fmt.Scanln(&Totalid)
	if len(this.CustomerArr) >= Totalid {
		var Name string
		var Sex string
		var Old int
		var Phone string
		var Email string
		fmt.Println("姓名：")
		fmt.Scanln(&Name)
		fmt.Println("性别：")
		fmt.Scanln(&Sex)
		fmt.Println("年龄：")
		fmt.Scanln(&Old)
		fmt.Println("电话：")
		fmt.Scanln(&Phone)
		fmt.Println("邮箱：")
		fmt.Scanln(&Email)
		var Customer = customermodel.NewCustomer(Name, Sex, Old, Phone, Email)
		this.CustomerArr[Totalid]=Customer
	} else {
		fmt.Println("请输入正确的编号！")
	}
}