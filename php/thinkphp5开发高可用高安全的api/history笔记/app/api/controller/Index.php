<?php
/**
 * Created by PhpStorm.
 * User: Administration
 * Date: 2020/5/24
 * Time: 17:07
 */
namespace app\api\controller;
use think\Controller;
class Index extends Controller{
 function index(){
     $datas = [
         'status' => 0,
         'msg' => "nihao"
     ];
     var_dump($datas);
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