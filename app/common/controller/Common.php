<?php
namespace app\common\controller;
use think\Controller;


class Common extends Controller
{

//    protected $beforeActionList = [
//        'nologin',
//    ];

//    public function _empty($name)
//    {
//        //这个是用户访问不存在的方法时，执行本方法。
//        return "当前方法不存在".$name;
//    }

    /*退出登录*/
    public function outLogin()
    {
        unset($_SESSION['username']);
        return $this->fetch('index/login');
    }


    /*登录页面*/
    public function noLogin()
    {
        if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
            return true;
        } else {
            return false;
//            return $this->fetch('index/login');

        }
    }

    /*增加了登录状态判定的跳转方法*/
    public function checkLogin($url = "/index/login")
    {
        if ($this->noLogin()) {
            return $this->fetch('/index/login');
        } else {
            $this->assign('username', $_SESSION['username']);
            return $this->fetch($url);
        }
    }

    /*文件上传*/
    public function upload($fileName = 'image')
    {
        $file = Request()->file("$fileName");
//        $size=$file->getSize();//获取文件大小，单位字节,可在此判断图片大小 并进行压缩，具体压缩方法待完善
//        var_dump($size);
//        exit;
        // 移动到框架应用根目录/public/uploads/image 目录下
        $info = $file->validate(['size' => 20971520, 'ext' => 'jpg,jpeg,bmp,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads/image');
        if ($info) {
            // 成功上传后 获取上传信息
            // 输出 后缀名
//                  echo $info->getExtension();
            // 输出 文件相对路径 如20160820/42a79759f284b767dfcb2a0197904287.jpg
            return $info->getSaveName();
//            // 输出 不带路径的文件名 如42a79759f284b767dfcb2a0197904287.jpg
//              echo $info->getFilename();
        } else {
            // 上传失败 获取错误信息
            return $file->getError();
        }
//        }
//        return false;
    }
}