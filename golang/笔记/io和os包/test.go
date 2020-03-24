package main

import (
	"bytes"
	"fmt"
)

func main() {
	//file, err := os.Open("./file1.txt")
	//if err != nil {
	//	log.Fatal(err)
	//}
	////Read读取数据写入p。本方法返回写入p的字节数。本方法一次调用最多会调用下层Reader接口一次Read方法，
	////因此返回值n可能小于len(p)。读取到达结尾时，返回值n将为0而err将为io.EOF

	////从文件中读取数据
	//buf := make([]byte, 128)
	////直接读取
	////read每次读取数据到buf中
	////for n, _ := file.Read(buf); n != 0; n, _ = file.Read(buf) {
	////	fmt.Println(string(buf[:n]))
	////}

	//if sw, ok := w.(stringWriter); ok {

	////读取到缓存中
	//reader := bufio.NewReader(file)
	//for n, _:=reader.Read(buf);n!=0 && io.EOF!=nil; n, _=reader.Read(buf){  //if err == io.EOF {//最后
	//	fmt.Println(string(buf[:n]))
	//}
	var buf bytes.Buffer
	//logger := log.New(&buf, "logger: ", log.Lshortfile)
	//logger.Println("Hello, log file!")
	fmt.Println()
	//fmt.Printf("%#v\n\r",&buf)
	//bufs := make([]byte, 12)
	bufs:=[]byte("nihao")
	n,s:=buf.Write(bufs)
	fmt.Printf("%v\n\r",n)
	fmt.Printf("%v\n\r",s)
	fmt.Printf("%#v\n\r",buf)
	fmt.Printf("%#v\n\r",bufs)
}
