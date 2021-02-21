<?php
//图片上传
namespace app\admin\common;

use app\admin\model\CommonModel;

class Uploader
{
    function __construct() {
        $model = new CommonModel;
        $this->model = $model;
    }

    //定义一个方法名upload_img，和view/TestImage文件夹下面的upload_img同名，提交信息时匹配文件
    public function upload_img($tableName, $imgFieldName, $idFieldName)
    {
        if (request()->isPost()) {

            $data = input('post.');//获取js中uploadBeforeSend传来的参数
            $key_id = $data['key_id'];//主键id
            $file = request()->file('file');//获取图片文件
            if ($file) {
                $info = $file->rule('date')->move(ROOT_PATH . 'public' . DS . 'uploads');// 移动到框架应用根目录/public/uploads/ 目录下
                if ($info) {
                    // 成功上传后 获取上传信息
                    $imgPath = "/uploads/" . $info->getSaveName();
                    $id_Data = $this->model->get_id_data($tableName, $key_id, $idFieldName);
                    $brand_img = $id_Data[$imgFieldName];
                    if (!empty($brand_img)) {
                        $brand_img = preg_replace_callback( '!s:(\d+):"(.*?)";!s', function($r){ return 's:'.strlen($r[2]).':"'.$r[2].'";'; }, $brand_img );
                        $arrImg = unserialize($brand_img);
                        array_push($arrImg, $imgPath);
                    } else {
                        $arrImg = [$imgPath];
                    }
                    $res = $this->model->update_id_data($tableName, [$imgFieldName => serialize($arrImg), $idFieldName => $key_id]);
                    if ($res) {
                        return true;
                    } else {
                        unset($info); //一定要unset之后才能进行删除操作，否则请求会被拒绝
                        $this->removeFile($imgPath); //删除上传失败文件
                        return false;
                    }
                } else {
                    // 上传失败获取错误信息
                    return false;
//                  echo $file->getError();
                }
            }
        }
    }

    //删除文件
    public function removeFile($path){
        unlink('.' . $path);
    }
}
