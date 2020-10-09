<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model;

class Base extends Controller
{
    protected function _initialize()
    {
        if (!$this->isLogin()) {
            return $this->redirect('login/login');
        }

    }

    public function isLogin()
    {
        $result=session(config('lib.session_user_name'));
        if ($result && $result->id) {
            return true;
        }
    }

}