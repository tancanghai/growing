<?php

namespace app\admin\common;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model;
class Admins
{
    public static function  password($password){
        $pad= md5($password.config('lib.password_salt'));
        return $pad;
    }

}