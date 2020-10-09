<?php

namespace app\admin\controller;


use app\admin\common\Upload;
use think\Controller;
use think\Db;
use think\Request;
use app\admin\common\Admins;
use app\admin\model;
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;

/**
 * 后台图片上传相关逻辑
 * Class Image
 * @package app\admin\controller
 */
class News extends Base
{
    /**
     * 图片上传
     */
    public function upload0($file = '')
    {

        $file = Request::instance()->file('file');
        // 把图片上传到指定的文件夹中
        $info = $file->move('upload');

        if ($info && $info->getPathname()) {
            $data = [
                'status' => 1,
                'message' => 'OK',
                'data' => '/' . $info->getPathname(),
            ];
            echo json_encode($data);
            exit;
        }

        echo json_encode(['status' => 0, 'message' => '上传失败']);

    }

    /**
     * 七牛图片上传
     *
     * http://otwueljs0.bkt.clouddn.com/2017/07/30d35201707310115086587.jpg
     * http://otwueljs0.bkt.clouddn.com/2017/07/30d35201707310115086587.jpg
     */
    public function upload()
    {
        try {
            $image = Upload::image();
        } catch (\Exception $e) {
            echo json_encode(['status' => 0, 'message' => $e->getMessage()]);
        }
        if ($image) {
            $data = [
                'status' => 1,
                'message' => 'OK',
                'data' => config('qiniu.image_url') . '/' . $image,
            ];
            echo json_encode($data);
            exit;
        } else {
            echo json_encode(['status' => 0, 'message' => '上传失败']);
        }
    }

    public function add()
    {

        if (request()->isPost()) {

            $data = input('post.');
            // 数据需要做检验 validate机制小伙伴自行完成

            //入库操作
            try {
                $id = model('News')->add($data);
            } catch (\Exception $e) {
                return $this->result('', 0, '新增失败');
            }

            if ($id) {
                return $this->result(['jump_url' => url('news/index')], 1, 'OK');
            } else {
                return $this->result('', 0, '新增失败');
            }
        } else {
            return $this->fetch('', [
                'cats' => config('cat.lists')
            ]);
        }
    }


    public function load()
    {
        $field = 'img';  // 对应webupload里设置的fileVal

        $savePath = './uploads/';    // 这里注意设置uploads文件夹的权限
        $saveName = time() . uniqid() . '_' . $_FILES[$field]['name']; // 为文件重命名
        $fullName = $savePath . $saveName;

        if (file_exists($fullName)) {
            $result = [
                'success' => false,
                'message' => '相同文件名的文件已经存在'
            ];
        } else {
            move_uploaded_file($_FILES[$field]["tmp_name"], $fullName);
            $result = ['success' => true, 'fullName' => $fullName];
        }

        return json_encode($result); // 将结果打包成json格式返回
    }

//上传至七牛云
    public function qiNiu()
    {
        $file = request()->file('file');
        $filename = $file->getInfo();
        if(empty($filename)) {
            exception('您提交的图片数据不合法', 404);
        }
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = "8vQAjlVbD3w-CxkeQqX8N5KYedXOq6yMZI4n5fG7";
        $secretKey = "PsZpwoEPB0vI5b4km1dQz58HSaeNPKnrZpyyfpSt";
        //要上传的空间
        $bucket = "tancanghai";
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        // $filePath = './php-logo.png';
        $filePath = $file->getRealPath();
        // 上传到七牛后保存的文件名
        //$key  = date('Y')."/".date('m')."/".substr(md5($file), 0, 5).date('YmdHis').rand(0, 9999).'.'.$ext;
        $key = date('Ymd') . '/' . str_replace('.', '0', microtime(1)) . '.' . $ext;
        //七牛外链路径
        $url = "http://pvrfqyqw5.bkt.clouddn.com";
        //保存到数据库的完整路径
        $urls = $url . "/" . $key;
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return json(['result' => 'error', 'msg' => "上传失败"]);
        } else {
            //保存至数据库
            $data['url'] = $urls;
            $id=session(config('lib.session_user_name'))['id'];
            $shu= Db::name('news')->where('user_id',$id)->field('image')->find();
            if(!empty($shu['image'])){
                $arrr=unserialize($shu['image']);
                $phone_imgs=array_merge($arrr,$urls);
                $urlss=serialize($phone_imgs);
            }else{
                $urlss=serialize(array($urls));
            }
            Db::name('news')->where('user_id',$id)->update('image',$urlss);
            return json(['result' => 'success', 'data' => $data, 'msg' => "上传成功"]);
        }
    }
}
