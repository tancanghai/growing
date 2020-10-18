<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->view->engine->layout('common/layout');
        return $this->fetch("index");
    }
}
