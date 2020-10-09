<?php

namespace app\api\controller;

use think\Controller;
use app\api\common\Info;
use app\api\common\ApiException;
use app\api\common\Aes;
use app\api\common\Aes2;
use app\api\common\IAuth;
use app\api\controller\Common;

class First extends common
{
    public function blog()
    {
        $data=[
            IAuth::setTime(),
            time()
        ];


        $header = request()->header();

        $data=input();
        $data= 'abcdefghij';
        $mode=new Aes2();
        $data=$mode->setSign($data);
        $str='wMmtQ1shhbBBWFyUIQSQCjQ2Gfardc6Gene66mJmsOI=';
         $data=$mode->decrypt($str);
        return Info::show(1, "成功", $data, 200);//正常返还数据
    }

    public function index()
    {
        $data = input();
        ddd;//错误服务端 服务端异常处理 500
        if ($data['key'] == 3) {
            throw new ApiException('您提交的数据不合法！', 401); //内部异常处理
        }
        return Info::show(1, "成功", $data, 200);//正常返还数据
    }

    public function create()
    {
        return 'create';
    }

    public function save()
    {
        return 'save';
    }

    public function read()
    {
        return 'read';
    }

    public function edit()
    {
        return 'edit';
    }

    public function update()
    {
        return 'update';
    }

    public function delete()
    {
        return 'delete';
    }
}