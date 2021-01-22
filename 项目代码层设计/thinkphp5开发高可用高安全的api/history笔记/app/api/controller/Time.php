<?php

namespace app\api\controller;

use think\Controller;
use app\api\common\Info;

//客户端每次调用前访问后端  取得时间 对比去掉时间差

//放开一个接口 获取时间
class Time extends Controller
{
    public function index()
    {
        return Info:: show(1, 'ok', time(), $code = 200);
    }
}