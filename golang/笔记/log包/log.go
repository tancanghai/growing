package main

import (
	"fmt"
	"github.com/op/go-logging"
	"os"
	"time"
)

var log = logging.MustGetLogger("example")
var format = logging.MustStringFormatter(
	`%{color}%{time:2006-01-02 15:04:05} %{level:.4s} > %{color:reset} %{message}`,
)

func InitLog() {
	ym := time.Now().Format("2006-01-02")

	fileName := Env + "_" + ym + ".log"

	logFile, err := os.OpenFile(fileName, os.O_CREATE|os.O_WRONLY, 0666)
	if err != nil {
		fmt.Printf("error: %v\n", err)
	}
	backend1 := logging.NewLogBackend(logFile, "", 0)
	backend2 := logging.NewLogBackend(os.Stderr, "", 0)

	backend1Formatter := logging.NewBackendFormatter(backend1, format)
	backend2Formatter := logging.NewBackendFormatter(backend2, format)

	backend1Leveled := logging.AddModuleLevel(backend1)
	backend1Leveled.SetLevel(logging.DEBUG, "")

	logging.SetBackend(backend1Leveled, backend1Formatter, backend2Formatter)
}
