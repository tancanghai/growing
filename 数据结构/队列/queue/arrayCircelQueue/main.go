package main

import (
	"errors"
	"fmt"
	"os"
)

//使用一个结构体管理环形队列
type CircelQueue struct {
	maxSize int    //4
	array   [4]int //数组
	head    int    //队首
	tail    int    //队尾
}

//添加到队列
func (this *CircelQueue) Push(val int) (err error) {
	if this.IsFull() {
		return errors.New("queue full")
	}
	//this.tail 在队列尾部，但是包含最后的元素
	this.array[this.tail] = val //把值给尾部
	this.tail = (this.tail + 1) % this.maxSize
	return
}

//取队列
func (this *CircelQueue) Pop() (val int, err error) {
	if this.IsEmpty() {
		return 0, errors.New("queue empty")
	}
	//取出,head指向队首，并且含队首元素
	val = this.array[this.head]
	this.head = (this.head + 1) % this.maxSize
	return
}

//显示队列
func (this *CircelQueue) ListQueue() {
	fmt.Println("环形队列情况如下：")
	//取出当前队列又多少个元素
	size := this.Size()
	if size == 0 {
		fmt.Println("队列为空")
	}
	//设计一个辅助变量，指向head
	tempHead := this.head
	for i := 0; i < size; i++ {
		fmt.Printf("arr[%d]=%d\t", tempHead, this.array[tempHead])
		tempHead = (tempHead + 1) % this.maxSize
	}
	fmt.Println()
}

//判断环形队列是否满了
func (this *CircelQueue) IsFull() bool {
	return (this.tail+1)%this.maxSize == this.head
}

//判断环形队列为空
func (this *CircelQueue) IsEmpty() bool {
	return this.tail == this.head
}

//取出环形队列有多少个元素
func (this *CircelQueue) Size() int {
	return (this.tail + this.maxSize - this.head) % this.maxSize
}

func main() {
	var key string
	var val int
	circelqueue := &CircelQueue{
		maxSize: 5, //数组最大下标的大小
		head:    0, //队列首
		tail:    0,
	}
	//var val int
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
			err := circelqueue.Push(val)
			if err != nil {
				fmt.Println("失败！原因：", err.Error())
			} else {
				fmt.Println("加入队列ok")
			}
		case "get":
			val, err := circelqueue.Pop()
			if err != nil {
				fmt.Println("取数据错误：", err.Error())
			} else {
				fmt.Println("从队列中取出一个数=", val)
			}
		case "show":
			circelqueue.ListQueue()
		case "exit":
			os.Exit(0)
		}
	}
}
