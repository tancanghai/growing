<?php
namespace app\admin\controller;

use think\Model;

class Index extends Model
{
    public function add()
    {
        return $this->fetch("add");
    }
}
