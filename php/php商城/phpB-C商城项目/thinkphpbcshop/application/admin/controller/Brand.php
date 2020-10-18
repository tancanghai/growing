<?php
namespace app\admin\controller;

use think\Controller;

class Brand extends Controller
{
    public function add()
    {
        $this->view->engine->layout('common/layout');
        return $this->fetch("add");
    }
}
