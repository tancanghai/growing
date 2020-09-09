<?php
//修改exception()参数数据
namespace app\api\common;

use think\Exception;
//可预见业务返回json
class ApiException extends Exception
{
    public $message = '';
    public $httpCode = 500;
    public $code = 0;
    public function __construct($message = '', $httpCode = 0,$code = 0)
    {
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;
    }

}