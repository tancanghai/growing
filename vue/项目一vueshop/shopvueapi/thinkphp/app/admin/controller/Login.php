<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\captcha\Captcha;
use app\admin\common\Admins;
use think\Session;

class Login extends Base
{
    public function _initialize(){}

//登陆
    public function login()
    {
        if($this->isLogin()){
            return $this->redirect('index/index');
        }else{
            if (Request::instance()->isPost()) {

                $data = input('post.');
                if (!captcha_check($data['code'])) {
                    return $this->error('验证码错误');
                }
                $model = model('AdminUser');
                $result = $model->where('username', $data['username'])->find();
                if ($result) {
                    //  $models=new Admins();
                    if (!$result['password'] == Admins::password($data['password'])) {
                        return $this->error('密码错误！');
                    }

                    //更新数据
                    $arrays = [
                        'last_login_ip' => request()->ip(),
                        'last_login_time' => date('Y-m-d H:i:s', time()),
                    ];
                    model('adminuser')->save($arrays, ['username' => $data['username']]);
                    $datas=model('adminuser')->where('username', $data['username'])->find();
                    //session
                    session(config('lib.session_user_name'), $datas);
                    $this->redirect('index/index');
                } else {
                    return $this->error('用户名不存在');
                }
            }
            return $this->fetch();
        }
    }

//    public function valid()
//    {
//        $data = input('param.');
//        if (captcha_check($data['code'])) {
//            return [statue => 1];
//        } else {
//            return [statue => 0];
//        }
//    }

//退出登陆
    public function logout()
    {
        session(config('lib.session_user_name'), null);
        return $this->success('成功退出！', 'login/login');
    }
}