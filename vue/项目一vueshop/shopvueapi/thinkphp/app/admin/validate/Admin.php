<?php
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{
    protected $rule = [
        'adminName'  =>  'require|max:25',
        'password' =>   'require|max:25',
        'phone'  =>  '/^1[34578]\d{9}$/',
        'email'   => 'email'
    ];
    protected  $msg = [
        'adminName.require' => '名称必须',
        'adminName.max'     => '名称最多不能超过25个字符',
        'password.require' => '名称必须',
        'password.max'     => '名称最多不能超过25个字符',
        'phone'   => '电话格式错误',
        'email'        => '邮箱格式错误',
        ];
}