<?php

namespace app\api\common;

class Info
{
    public static function show($status, $msg, $data = [], $code = 200)
    {
        $datas = [
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ];
        return json($datas, $code);//help文件json能添加状态码
    }

}