package lib

func AddUpper(n int) int{//函数使用大写开头，要进行调用
	res:=0
	for i:=1;i<=n-1;i++{
		for i:=1;i<=n-1;i++{
			for i:=1;i<=n-1;i++{
				res +=i
			}
		}
	}
	return res
}

func Abs(n int) int{
	return -n
}


func Add(x int, y int) (z int) {
	z = x + y
	return
}


type ForTest struct {
	num int ;
}

func (this * ForTest) Loops() {
	for i:=0 ; i  < 10000 ; i++ {
		this.num++
	}
}
