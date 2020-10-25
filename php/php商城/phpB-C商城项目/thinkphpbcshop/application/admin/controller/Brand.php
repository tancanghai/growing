<?php
namespace app\admin\controller;

use think\Controller;
use think\Config;

class Brand extends Controller
{
    public function add()
    {
//        $this->view->engine->layout('common/layout');
        Config::set('default_ajax_return','html');
        return $this->fetch("add");
    }
}
