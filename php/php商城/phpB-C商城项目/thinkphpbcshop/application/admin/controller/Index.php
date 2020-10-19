<?php
namespace app\admin\controller;

use think\Controller;
use think\Config;

class Index extends Controller
{
    public function index()
    {
//        $this->view->engine->layout('common/layout');
        return $this->fetch("index");
    }
}
