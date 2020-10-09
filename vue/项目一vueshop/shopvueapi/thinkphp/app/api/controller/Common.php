<?php
//公共继承校验
namespace app\api\controller;

use http\Env\Request;
use think\Controller;
use app\api\common\ApiException;
use app\api\common\IAuth;
use app\api\common\Aes2;
use think\Cache;
use app\api\common\Info;

class Common extends Controller
{
    public $header = [];

    public function _initialize()
    {
        $this->checkRequestAuth();
    }

    //检查每次APP请求是否合法
    public function checkRequestAuth()
    {
        //获取headers信息
        $header = request()->header();
        //基础数据校验
        if (!$header['sign']) {
            throw new ApiException('sign不存在', 401);
        }
        if (!in_array($header['app-type'], config('apptypes'))) {
            throw new ApiException('app_type不合法', 401);
        }

        //检验Sign能否通过
        $result = $this->signCheckPass($header);
        if (!$result) {
            throw new ApiException('授权码sign不合法', 401);

        }

        //把sign写入缓存//确认唯一性
        Cache::set($header['sign'],1,config('app_sign_cache_time'));

        //把header头信息放入common中 以后类继承直接可以使用
        $this->header = $header;

    }

    //检查sign是否通过
    public function signCheckPass( $header = [])
    {
        //sign的唯一性 //文件缓存
        if(Cache::get($header['sign'])){
            return false;
        }
        //解密
        $str = Aes2::decrypt($header['sign']);
        //在上面已经校验了
        if (empty($str)) {
            return false;
        }
        //parse_str — 将字符串解析成多个变量
        parse_str($str, $array);
        //自己定义所需要的数据 例如 k=3&dd=44&did=22298888   可以多校验 也可以校验k参数合法性
        if (!is_array($array) || empty($array['did']) || $array['did'] != $header['did']) {//校验did合法   当解密sign时候对比header头中的did是否对应
            return false;
        }
        //设置请求过时时间
        if(time()-ceil($array['time']/1000)>config('app_sign_time')){
            throw new ApiException('过时失效', 401);
        }
        return true;
    }

}