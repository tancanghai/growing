package main

import "fmt"

func main() {
	var key int
	var loop bool=false
	var budget string
	var money float64=0.00
	var totalmoney float64=0.00
	var note string
	var totalstring string=""
	var exits string=""
	for {
		fmt.Println("家庭收支记账软件----------\n")
		fmt.Println("1  收支明细\n")
		fmt.Println("2  登记收入\n")
		fmt.Println("3  登记支出\n")
		fmt.Println("4  退出\n")
		fmt.Print("请选择（1-4）：")
		fmt.Scanln(&key)
		switch key {
		case 1:

			if totalstring==""{
				fmt.Println("当前没有收支明细......来一笔把！\n")
			}else{
				fmt.Println("当前收支明细记录-----------\n")
				fmt.Println("收支    收支金额    说  明    账户金额\n")
			}
			fmt.Println(totalstring)
			break
		case 2:
			budget ="收入"
			fmt.Println("本次收入金额：\n")
			fmt.Scanln(&money)
			fmt.Println("本次收入说明：\n")
			fmt.Scanln(&note)
			totalmoney += money
			totalstring += fmt.Sprintf("%v    %v     %v     %v\n",budget,money,note,totalmoney)
			break
		case 3:
			budget ="支出"
			fmt.Println("本次支出金额：\n")
			fmt.Scanln(&money)
			if money>totalmoney{
				fmt.Print("余额不足！")
				break
			}
			fmt.Println("本次支出说明：\n")
			fmt.Scanln(&note)
			totalmoney -= money
			totalstring += fmt.Sprintf("%v    %v     %v     %v\n",budget,money,note,totalmoney)
			break
		case 4:
			fmt.Print("你确定要退出（yes/no）:\n")
			fmt.Scan(&exits)
			for{
				if  exits=="yes" || exits=="no"{
					if  exits=="yes"{
						loop=true
					}
					break
				}else{
					fmt.Print("选择错误，请重新输入：")
					fmt.Scan(&exits)
				}
			}
			break
		}
		if loop{
			break
		}
	}
}
