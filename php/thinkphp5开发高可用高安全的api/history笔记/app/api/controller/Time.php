<?php

namespace app\api\controller;

use think\Controller;
use app\api\common\Info;

class Time extends Controller
{
    public function index()
    {
        return Info:: show(1, 'ok', time(), $code = 200);
    }
}