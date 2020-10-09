<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\common\Admins;
use app\admin\model;
class Admin extends Base
{
    public function index()
    {

        return $this->fetch();
    }

    public function add()
    {
        if (Request::instance()->isPost()){
            $data = input('post.');
            $validate = validate('Admin');
            $result = $validate->check($data);
            if (!$result) {
                $this->error($validate->getError());
            }
            $value=Db::name('admin_user')->where('username',$data['adminName'])->value('username');
            if($value){
                $this->error('该用户已存在！');
            }
            //$models=new Admins();
            $datas = [
                'username' => $data['adminName'],
                'password' =>Admins::password($data['password']),
                //sex=>$data['sex'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'statue' => NORMAL_STATUS,
            ];
            $model = model('AdminUser');
            try {
                $id = $model->add($datas);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            if($result){
                $this->success($id);
            }
        }

        //var_dump($datas);exit;
        return $this->fetch();
    }
}