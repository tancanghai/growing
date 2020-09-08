package lib
import "testing"

func Benchmark_Division(b *testing.B) { //性能测试Benchmark_ 开头
	for i := 0; i < b.N; i++ { //use b.N for looping
		Add(1000000, 1000000)
	}
}

func Benchmark_TimeConsumingFunction(b *testing.B) {
	b.StopTimer() //调用该函数停止压力测试的时间计数

	//做一些初始化的工作,例如读取文件数据,数据库连接之类的,
	//这样这些时间不影响我们测试函数本身的性能

	b.StartTimer() //重新开始时间
	for i := 0; i < b.N; i++ {
		AddUpper(1000)
	}
}

type AddArray struct {
	result  int;
	add_1   int;
	add_2   int;
}


//以下俩个例子是测试 运行速度 和 并发运行速度 对比  也是官方例子可以直接拷贝使用
func BenchmarkLoops(b *testing.B) {
	var test ForTest
	ptr := &test
	// 必须循环 b.N 次 。 这个数字 b.N 会在运行中调整，以便最终达到合适的时间消耗。方便计算出合理的数据。 （ 免得数据全部是 0 ）
	for i:=0 ; i<b.N ; i++ {
		ptr.Loops()//调用函数测试
	}
}
// 测试并发效率
func BenchmarkLoopsParallel(b *testing.B) {
	b.RunParallel(func(pb *testing.PB) {
		var test ForTest
		ptr := &test
		for pb.Next() {
			ptr.Loops()//调用函数测试
		}
	})
}

