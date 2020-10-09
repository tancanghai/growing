<?php

namespace app\admin\model;

use think\Model;

class AdminUser extends Model
{
    protected $autoWriteTimestamp = 'datetime';
    public function add($datas)
    {
        $result = $this->allowField(true)->save($datas);
        $id = $result->id;
        return $id;
    }
}