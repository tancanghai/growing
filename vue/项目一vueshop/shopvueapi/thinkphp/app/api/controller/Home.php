<?php
/**
 * Created by PhpStorm.
 * User: Administration
 * Date: 2020/5/24
 * Time: 17:07
 */
namespace app\api\controller;
use think\Controller;
use app\api\common\Info;
use app\api\common\ApiException;
use app\api\common\Aes;
use app\api\common\Aes2;
use app\api\common\IAuth;
use app\api\controller\Common;
class Home extends Common{

    public function home_index()
    {
        $data=[
            "http://www.vueshop.com/static/image/yunduo.jpg",
            "http://www.vueshop.com/static/image/zhangjiajie.jpg",
            "http://www.vueshop.com/static/image/zhulin.jpg"
        ];
        return Info::show(1, "成功", $data, 200);//正常返还数据
    }
    public function create()
    {
        return 'create';
    }

    public function save()
    {
        return 'save';
    }

    public function read()
    {
        return 'read';
    }

    public function edit()
    {
        return 'edit';
    }

    public function update()
    {
        return 'update';
    }

    public function delete()
    {
        return 'delete';
    }
}