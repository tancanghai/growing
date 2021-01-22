<?php

namespace app\api\common;

use app\api\common\Info;
use think\exception\Handle;
//不可预返回json
class ApiHandleException extends Handle
{
    public $httpCode=500;

    public function render(\Exception $e)
    {
        //打开调试的时候使用父render
        if(config('app_debug')==true){
            return parent::render($e);
        }
        //修改内部异常处理时候的状态码
        if ($e instanceof ApiException) {
            $this->httpCode = $e->httpCode;
        }
        //服务端异常返还json数据
            return Info::show(0, $e->getMessage(), [], $this->httpCode);//错误时候执行这条代码  返回例如：{"stauts":0,"data":[],"msg":"Parse error: syntax error, unexpected 'rr' (T_STRING)"}


    }
}