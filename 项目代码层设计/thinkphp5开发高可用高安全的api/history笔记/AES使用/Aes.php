<?php
namespace app\api\common;

/**
 * aes 加密 解密类库
 * @by singwa
 * Class Aes
 * @package app\common\lib
 */
class Aes
{
    /**
     * method 为AES-128-CBC时
     * @var string传入要加密的明文
     * 传入一个16字节的key
     * 传入一个16字节的初始偏移向量IV
     */
    private static $method = 'AES-128-CBC';
    private static $key = 'contentWindowHig';
    private static $options = OPENSSL_RAW_DATA;
    private static $iv = 'contentDocuments';

    public static function getKey()
    {
        return self::$key;
    }
    public function __construct()
    {
        //  self::$key = md5(self::$key,true);
    }

    public static function setMethod($method){
        self::$method = $method;
    }
    public static function setKey($key){
        self::$key = $key;
    }
    /**
     * @param $options 可取值 OPENSSL_ZERO_PADDING OPENSSL_RAW_DATA
     */
    public static function setOptions($options){
        self::$options = $options;
    }

    public static function encrypt($input){
        $key = substr(md5(self::$key),0,16);
        $iv = substr(md5(self::$iv),0,16);
        $data = base64_encode(openssl_encrypt($input,"AES-128-CBC",$key,OPENSSL_RAW_DATA,$iv));
        return $data;
    }

    /**
     * @param $input
     * @return bool|string
     * todo rtrim
     */
    public static function decrypt($input){
        $key = substr(md5(self::$key),0,16);
        $iv = substr(md5(self::$iv),0,16);
        $data = openssl_decrypt(base64_decode($input),"AES-128-CBC",$key,OPENSSL_RAW_DATA,$iv);
        return $data;
    }

}
