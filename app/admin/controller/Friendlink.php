<?php

namespace app\admin\controller;

use think\Db;
use app\common\controller\Common;

class Friendlink extends Common
{
    public function index()
    {
        $res = model('Friendlink')->select();
        foreach ($res as $key => $val) {
            $data["$key"] = $val;
        }
        $this->assign('data', $data);
        return $this->checkLogin('index');
    }

    public function edit()
    {
        if (isset($_GET['id']) && intval($_GET['id']) > 0) {
            $id = input('get.id/d');
            $data = model('Friendlink')->find($id);
        } else {
            $data = ['img' => '', 'name' => '', 'url' => ''];
        }
        $data['img'] = noImage($data['img']);

        $this->assign('data', $data);
        return $this->checkLogin('edit');
    }

    public function add()
    {
        if ($this->noLogin()) {
            return $this->fetch('/index/login');
        } else {
            $data['name'] = input('post.name');
            $data['url'] = input('post.url');
            if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
                //id为0 则新增
                switch ($_FILES['image']['error']) {
                    case 0:
                        $data['img'] = $this->upload('image');
                        break;
                    case 1:
                    case 2:
                        alert('图片大小超出服务器限制', 'edit');
                        break;
                    case 3:
                        alert('图片文件仅有部分被上传', 'edit');
                        break;
//                        case 4:
//                            alert('没有找到要上传的图片文件','edit');
//                            break;
                    case 5:
                        alert('服务器临时文件夹丢失', 'edit');
                        break;
                    case 6:
                        alert('图片文件写入临时文件夹出错', 'edit');
                        break;
                }

//                if ($_FILES['image']['error'] == 0) {
//                    $data['img'] = $this->upload('image');
//                }
                $res = model('Friendlink')->create($data);
                if ($res) {
                    alert('发布成功', "index");
                } else {
                    alert('发布失败', 'edit');
                }
            } else {
                $data['id'] = input('get.id/d');
                switch ($_FILES['image']['error']) {
                    case 0:
                        $data['img'] = $this->upload('image');
                        break;
                    case 1:
                    case 2:
                        alert('图片大小超出服务器限制', 'edit');
                        break;
                    case 3:
                        alert('图片文件仅有部分被上传', 'edit');
                        break;
//                        case 4:
//                            alert('没有找到要上传的图片文件','edit');
//                            break;
                    case 5:
                        alert('服务器临时文件夹丢失', 'edit');
                        break;
                    case 6:
                        alert('图片文件写入临时文件夹出错', 'edit');
                        break;
                }
                $res = model('Friendlink')->update($data);
                if ($res) {
                    alert('更新成功', 'index');
                } else {
                    alert('更新失败', 'edit');
                }
            }
        }
    }
}
