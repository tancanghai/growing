<?php

namespace app\api\controller;

use app\api\common\ApiException;
use app\api\common\Aes2;


//客户端所有需要验证是否登陆的页面都需要继承这个类
class LoginBase extends Common
{
    public $user = [];

    public function _initialize()
    {
        //使用父类的初始化方法  为了不覆盖父类的初始化方法
        parent::_initialize();
        if ($this->isLogin()) {
            throw new ApiException('您没有登陆', 401);
        }


    }

    //判断是否登陆  加上自己自定义加密token的内容 与sign相似
    public function isLogin()
    {
        //传输的数据没有token
        if (empty($this->header['token'])) {
            return false;
        }
        //解密不存在token
        $str = Aes2::decrypt($this->header['token']);
        if (empty($str)) {
            return false;
        }
        //没有匹配到||
        if (!preg_match('/||/', $str)) {
            return false;
        }

        list($token, $id) = explode("||", $str);
        //数据库中查找此token数据
        $users = User::get(['token' => $token]);
        if (!$users || $users->status != 1) {
            return false;
        }

        //判断时间是否过期 对比数据库中的token失效时间
        if (time() > $users->time_out) {
            return false;
        }
        //把用户数据赋值给user
        $this->user = $users;
        return true;
    }


}