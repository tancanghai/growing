<?php
//公共继承校验
namespace app\api\controller;

use app\api\common\IAuth;
use app\api\common\Aes2;
use  app\api\common\Info;

class FirstLogin
{
    //注册或者第一次登陆 例如第三方登陆 生成token保存至数据库  //接收这些用户数据时 最好每个数据都加密处理再传输
    public function save()
    {
        if (!request()->isPost()) {
            return Info::show(0, '您没有权限', '', 403);
        }
        $param = input();
        if (empty($param['phone'])) {
            return Info::show(0, '手机不合法', '', 404);
        }
        if (empty($param['code'])) {
            return Info::show(0, '验证码不合法', '', 404);
        }
//
        //校验短信验证码
//        $code=Alidayu::checkSmsIdentify($param['phone']);
//        if(!$code!=$param['code']){
//            return Info::show(0,'手机验证码验证码不存在','',404);
//        }

        //注册或者第一次登陆 例如第三方登陆 生成token保存至数据库
        $token = IAuth::setAppLoginToken($param['phone']);
        $data = [
            'token' => $token,//数据库保存的token token唯一
            'time_out' => strtotime("+7 days"),//设置登陆失效时间 7天  //每次登陆都需要重新设置
            'username' => $param['phone'],
            'status' => 1,
            'phone' => $param['phone']
        ];
        $id = model('user')->add($data);

        if ($id) {
            $result = [
                'token' => Aes2::encrypt($token . "||" . $id),//传输token时确保安全 可以再使用sign一样加密  //自己更改自己的写法
            ];
            return Info::show(1, '成功', $result, 200);
        } else {
            return Info::show(0, '登陆失败', [], 500);
        }
    }


}