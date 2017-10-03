<?php

namespace app\admin\controller;

use app\common\controller\Common;
use think\Db;

class Product extends Common
{
    /*产品分类数据存储*/
    public
    function doProCateAdd()
    {
        //$this->request->post('username'); request的POST方法
        if ($this->noLogin()) {
            return $this->fetch('login');
        } else {
            if (!isset($_POST['catename']) || empty($_POST['catename'])) {
                alert('分类名称不允许为空', 'proCateEdit');
            } else {
                $catename = input('post.catename');
                $pid = input('post.pid');
                $data = array('catename' => $catename, 'pid' => $pid);
                //id 不存在 或者id等于零 则进行新增分类
                if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
                    $res = model("Productcate")->create($data);
                    if ($res) {
                        alert('发布成功', "proCate?pid=$pid");
                    } else {
                        alert('发布失败', 'proCateEdit');
                    }
                }//编辑分类
                elseif (isset($_GET['id']) && intval($_GET['id']) > 0) {
                    $id = input('get.id/d');
                    $res = model("Productcate")->where(['id' => $id])->update($data);
                    if ($res) {
                        alert('更新成功', "proCate?pid=$pid");
                    } else {
                        alert('更新失败', 'proCateEdit');
                    }
                }
            }
        }
    }

    /*产品列表页*/
    public
    function proList()
    {
        //通过表单选择框GET过来的分类值，来决定从数据库取哪些分类中的产品
        $cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
        if ($cid > 0) {
            $res = model('product')
                ->alias('a')
                ->join('productcate b', 'a.cid = b.id')
                ->where(['cid' => $cid])
                ->field('a.*,b.catename')
                ->order(['order' => 'DESC', 'update_time' => 'DESC'])
                ->paginate(12);
        } else {
            $res = model('product')
                ->alias('a')
                ->join('productcate b', 'a.cid = b.id')
                ->field('a.*,b.catename')
                ->order(['order' => 'DESC', 'update_time' => 'DESC'])
                ->paginate(12);
        }
        if (isset($_GET['keywords']) || !empty($_GET['keywords'])) {
            $keywords = input('get.keywords');
            $res = model('product')
                ->alias('a')
                ->join('productcate b', 'a.cid = b.id')
                ->where('title', 'like', "%$keywords%")
                ->field('a.*,b.catename')
                ->order(['order' => 'DESC', 'update_time' => 'DESC'])
                ->paginate(12);
        }
        //取出新闻列表数据和新闻分类数据，并且传入模板文件
        $cate = model('productcate')->field(['id', 'catename'])->select();
        $this->assign('data', $res);
        $this->assign('cate', $cate);
        return $this->checkLogin("proList");
    }

    /*产品编辑页*/
    public
    function proEdit()
    {
        $cate = Db::table('productcate')->field(['id', 'catename'])->select();
        $this->assign('cate', $cate);
        #初始化变量的值
        $data = array('id' => 0, 'title' => '', 'pic' => "", 'desc' => '', 'content' => '', 'cid' => 1, 'order' => 0);

//判断是否有GET id值，若有值则从数据库取出相应的值，准备填入input等标签
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = input('get.id/d');
            $res = Db::table('product')->find($id);
            if ($res && !empty($res)) {
                foreach ($res as $key => $val) {
                    $data["$key"] = $val;
                }
            }
        }
        $data['pic'] = noImage($data['pic']);
        $this->assign('data', $data);
        return $this->checkLogin("proEdit");
    }

    /*产品分类页*/
    public
    function proCate()
    {
        if (isset($_GET['pid']) && $_GET['pid'] > 0) {
            $pid = input('get.pid/d');
            $cate = Db::table('productcate')
                ->where(['pid' => $pid])
                ->field(['id', 'pid', 'catename'])
                ->paginate(10);
            $pidRes = model("Productcate")->field(['catename','pid'])->find($pid);
            $parentName = $pidRes['catename'];//取出的是对象，取出Pid对应的分类名称
            $parentPid=$pidRes['pid'];

        } else {
            $cate = Db::table('productcate')
                ->field(['id', 'pid', 'catename'])
                ->where(['pid' => 0])
                ->paginate(10);
            $parentName = "无";
            $parentPid=0;

        }
        //取出产品列表数据和产品分类数据，并且传入模板文件
        $this->assign('parentName', $parentName);
        $this->assign('parentPid', $parentPid);

        $this->assign('cate', $cate);
        return $this->checkLogin('proCate');
    }

    /*产品分类编辑页*/
    public function proCateEdit()
    {
//判断是否有GET id值，若有值则从数据库取出相应的值，准备填入input等标签
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = input('get.id/d');
            $res = Db::table('productcate')->where(['id' => $id])->find();
            if ($res && !empty($res)) {
                foreach ($res as $key => $val) {
                    $data["$key"] = $val;
                }
            }
        } else {
            $data = array('id' => 0, 'catename' => '');
        }
        if (isset($_GET['pid']) && $_GET['pid'] > 0) {
            $pid = input('get.pid/d');
            $res = model('Productcate')
                ->where(['id' => $pid])
                ->field('catename')
                ->find();
            $parentName = $res['catename'];
        } else {
            $parentName = "空";
        }
        $this->assign('parent', $parentName);
        $this->assign('data', $data);
        return $this->checkLogin('proCateEdit');
    }

    /*产品详情数据处理*/
    public
    function doProAdd()
    {
        if ($this->noLogin()) {
            return $this->fetch('login');
        } else {
            if (!isset($_POST['title']) || empty($_POST['title'])) {
                alert('标题不允许为空', 'newsEdit');
            } else {
                $data['title'] = input('post.title');
                $data['desc'] = input('post.desc');
                $data['cid'] = input('post.cateId');
                $data['update_time'] = time();
                $data['order'] = input('post.order/d');
                if(!isset($_POST['content'])){
                    $content='';
                }else{
                    $content=input('post.content');
                }
                $data['content']=$content;
                //这里是通过验证器 来验证用户输入内容的合法性。验证规则在同一个模块下的validate文件夹下的类文件，例如Product.php
//                $data = array('title' => $title, 'desc' => $desc, 'update_time' => $createTime, 'create_time' => $createTime, 'content' => $content, 'cid' => $cateId, 'order' => $order);
//                $validate = validate('Product');//实例化验证器
//                if (!$validate->check($data)) {
//                    dump($validate->getError());
//                    exit;
//                }
                //id 不存在 或者id等于零 则进行新增文章
                if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
                    $data['create_time']=time();
                        //判断用户上传图片情况
                    switch ($_FILES['image']['error']){
                        case 0:
                            $data['pic'] = $this->upload('image');
                        break;
                        case 1:
                        case 2:
                            alert('图片大小超出服务器限制','proEdit');
                            break;
                        case 3:
                            alert('图片文件仅有部分被上传','proEdit');
                            break;
//                        case 4:
//                            alert('没有找到要上传的图片文件','proEdit');
//                            break;
                        case 5:
                            alert('服务器临时文件夹丢失','proEdit');
                            break;
                        case 6:
                            alert('图片文件写入临时文件夹出错','proEdit');
                            break;
                    }
                    $res = model("Product")->create($data);

                    if ($res) {
                        alert('发布成功', 'proList');
                    } else {
                        alert('发布失败', 'proEdit');
                    }
                }else{
                    //编辑产品
                    $data['id'] = input('get.id/d');
                    //判断用户上传图片情况
                    switch ($_FILES['image']['error']){
                        case 0:
                            $data['pic'] = $this->upload('image');
                            break;
                        case 1:
                        case 2:
                            alert('图片大小超出服务器限制','proEdit');
                            break;
                        case 3:
                            alert('图片文件仅有部分被上传','proEdit');
                            break;
//                        case 4:
//                            alert('没有找到要上传的图片文件','proEdit');
//                            break;
                        case 5:
                            alert('服务器临时文件夹丢失','proEdit');
                            break;
                        case 6:
                            alert('图片文件写入临时文件夹出错','proEdit');
                            break;
                    }
                    $res = model("Product")->update($data);
                    if ($res) {
                        alert('更新成功', 'proList');
                    } else {
                        alert('更新失败', 'proEdit');
                    }
                }
            }
        }
    }

    /*产品删除*/
    public
    function proDel()
    {
        if ($this->noLogin()) {
            return $this->fetch('login');
        } else {
            if (isset($_GET['id']) && intval($_GET['id']) > 0) {
                $id = input('get.id/d');
                $res = model("Product")->destroy($id);
                if ($res) {
                    alert('删除成功', 'proList');
                } else {
                    alert('删除失败', 'proList');
                }
            } else {
                alert('ID错误', 'proList');
            }
        }
    }


    /*产品分类删除*/
    public
    function proCateDel()
    {
        if ($this->noLogin()) {
            return $this->fetch('login');
        } else {
            if (isset($_GET['id']) && intval($_GET['id']) > 0) {
                $id = input('get.id/d');
                //通过获取到的ID 来判断 当前ID下 是否还存在子分类
                $pidRes = model('Productcate')->where(['pid' => $id])->find();
                //获取来源页的PID 用户删除后的返回
                $pid=input('get.pid/d');
                if ($pidRes) {
                    alert('当前分类下存在子分类，请删除后再试', "proCate?pid=$pid");
                } else {
                    $res = model("Productcate")->destroy($id);
                    if ($res) {
                        alert('删除成功', "proCate?pid=$pid");
                    } else {
                        alert('删除失败', "proCate?pid=$pid");
                    }
                }
            } else {
                alert('ID错误', 'proCate');
            }
        }
    }
}