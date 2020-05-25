<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    'default_return_type' => 'json',  //将输出的字符串和数组转换成json
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle' => '\app\api\common\ApiHandleException',

    //'password_pre_halt' => '_#sing_ty',// 密码加密盐
    'aeskey' => 'sgg45747ss223455',//aes 密钥 , 服务端和客户端必须保持一致
    'aesvi'  => 'sgg67895ss232459',//aes vi , 服务端和客户端必须保持一致
    'apptypes' => [//app类型
        'ios',
        'android',
    ],
    'app_sign_time' => 1000,// sign失效时间
    'app_sign_cache_time' => 60,// sign 缓存失效时间
    'login_time_out_day' => 7,// 登录token的失效时间
];
