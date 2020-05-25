<?php

namespace app\api\common;

use app\api\common\Aes2;

class IAuth
{
    //设置sign 把一个定一好的数组例如（把header头里头部分信息）拼装成字符串加密然后 校验数据合法性
    //例如：did 对比header头信息和sign里头信息是否对应的上
    public static function setSign($data = [])
    {
        //1.按字段排序
        ksort($data);
        //拼接成字符串
        $str = http_build_query($data);//自己定义所需要的数据 例如 k=3&dd=44&did=22298888
        //aes加密
        $string = Aes2:: encrypt($str);
        return $string;
    }

    //设置13位的时间戳  取13就是为了防止和did重复
    public static function setTime()
    {
        list($time1, $time2) = explode(' ', microtime());//0.27165800 1379776428
        $time = $time2.ceil($time1 * 1000);//ceil()ceil — 进一法取整
        return $time;
    }

}