<?php
namespace app\admin\controller;
use think\Controller;
class Welcome extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}
