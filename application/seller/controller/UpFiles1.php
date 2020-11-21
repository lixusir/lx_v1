<?php
namespace app\seller\controller;
class UpFiles extends SellerBase
{
    public function upload()
    {
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $type = input('param.type');
        $upload_path = ROOT_PATH . 'public' . DS . 'uploads';
        $imgPath = '/uploads/';
        if ($type) {
            $upload_path = $upload_path . DS . $type;
            $imgPath = $imgPath . $type . '/';
        }
        if (!is_dir($upload_path)) {
            @mkdir($upload_path, 0777, true);
        }
        $info = $file->move($upload_path);
        if ($info) {
            $result['code'] = 1;
            $result['info'] = '图片上传成功!';
            $path = str_replace('\\', '/', $info->getSaveName());
            $sourceFile = $imgPath . $path;
            $result['url'] = $sourceFile;
            //压缩图片
//            $imgFiles = $upload_path. DS .$info->getSaveName();
//            $imgFiles = str_replace('\\', '/',$imgFiles);
//            compressPic($imgFiles);
            return $result;
        } else {
            // 上传失败获取错误信息
            $result['code'] = 0;
            $result['info'] = '图片上传失败!';
            $result['url'] = '';
            return $result;
        }
    }
    public function uploadsss()
    {
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        $res = hwObsUpload($file);
        if($res['code']!=200){
            // 上传失败获取错误信息
            $result['code'] = 0;
            $result['info'] = '图片上传失败!';
            $result['url'] = '';
            return $result;
        }
        $result['code'] = 1;
        $result['info'] = '图片上传成功!';
        $result['url'] = $res['url'];
        $result['img'] = $res['img'];
        return $result;
    }

    public function file()
    {
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

        if ($info) {
            $result['code'] = 0;
            $result['info'] = '文件上传成功!';
            $path = str_replace('\\', '/', $info->getSaveName());

            $result['url'] = '/uploads/' . $path;
            $result['ext'] = $info->getExtension();
            $result['size'] = byte_format($info->getSize(), 2);
            return $result;
        } else {
            // 上传失败获取错误信息
            $result['code'] = 1;
            $result['info'] = '文件上传失败!';
            $result['url'] = '';
            return $result;
        }
    }

    public function pic()
    {
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            $result['code'] = 1;
            $result['info'] = '图片上传成功!';
            $path = str_replace('\\', '/', $info->getSaveName());
            $result['url'] = '/uploads/' . $path;
            return json_encode($result, true);
        } else {
            // 上传失败获取错误信息
            $result['code'] = 0;
            $result['info'] = '图片上传失败!';
            $result['url'] = '';
            return json_encode($result, true);
        }
    }

    //编辑器图片上传
    public function editUpload()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            $result['code'] = 0;
            $result['msg'] = '图片上传成功!';
            $path = str_replace('\\', '/', $info->getSaveName());
            $result['data']['src'] = __PUBLIC__ . '/uploads/' . $path;
            $result['data']['title'] = $path;
            return json_encode($result, true);
        } else {
            // 上传失败获取错误信息
            $result['code'] = 1;
            $result['msg'] = '图片上传失败!';
            $result['data'] = '';
            return json_encode($result, true);
        }
    }

    //多图上传
    public function upImages()
    {
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            $result['code'] = 0;
            $result['msg'] = '图片上传成功!';
            $path = str_replace('\\', '/', $info->getSaveName());
            $result["src"] = '/uploads/' . $path;
            return $result;
        } else {
            // 上传失败获取错误信息
            $result['code'] = 1;
            $result['msg'] = '图片上传失败!';
            return $result;
        }
    }

    public function addFile()
    {
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $from = request()->param('from');
        $upload_path = ROOT_PATH . 'public' . DS . 'uploads';
        $imgPath = '/uploads/';
        if ($from) {
            $upload_path = $upload_path . DS . $from;
            $imgPath = $imgPath . $from . '/';
        }
        if (!is_dir($upload_path)) {
            @mkdir($upload_path, 0777, true);
        }
        $info = $file->move($upload_path);
        if ($info) {
            $result['code'] = 1;
            $result['info'] = '文件上传成功!';
            $path = str_replace('\\', '/', $info->getSaveName());
            $result['url'] = $imgPath . $path;
            return $result;
        } else {
            // 上传失败获取错误信息
            $result['code'] = 0;
            $result['info'] = '文件上传失败!';
            $result['url'] = '';
            return $result;
        }
    }

}