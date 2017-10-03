<?php
namespace app\admin\controller;
use think\Db;
use app\common\controller\Common;
class Infopage extends Common
{


    /*单页信息列表页*/
    public function infoPage()
    {
        $res = Db::table('info')->select();
        $this->assign('data', $res);
        return $this->checkLogin('infoPage');
    }

    /*单页信息编辑页*/
    public function infoEdit()
    {
//判断是否有GET id值，若有值则从数据库取出相应的值，准备填入input等标签

        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = intval($_GET['id']);
            $res = Db::table('info')->where(['id' => $id])->find();
            if ($res && !empty($res)) {
                foreach ($res as $key => $val) {
                    $data["$key"] = $val;
                }
            }
        } else {
            return $this->checkLogin('infoPage');
        }
        $this->assign('data', $data);
        return $this->checkLogin('infoEdit');
    }


    /*单页信息数据存储*/
    public function doInfoAdd()
    {
        if ($this->noLogin()) {
            return $this->fetch('login');
        } else {
            if (!isset($_POST['title']) || empty($_POST['title'])) {
                alert('标题不允许为空', 'infoEdit');
            } else {
                $title = input('post.title');
                if(!isset($_POST['content'])){
                    $content='';
                }else{
                    $content=input('post.content');
                }
                //id 不存在 或者id等于零 则进行新增文章
                if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
                    $data = array('title' => $title, 'content' => $content);

                    $res = model('Info')->create($data);

                    if ($res) {
                        alert('发布成功', 'infoPage');
                    } else {
                        alert('发布失败', 'infoEdit');
                    }
                }//编辑产品
                elseif (isset($_GET['id']) && intval($_GET['id']) > 0) {
                    $id = intval($_GET['id']);
                    $data = array('id' => $id, 'title' => $title, 'content' => $content);
                    $res = model('Info')->update($data);
                    if ($res) {
                        alert('更新成功', 'infoPage');
                    } else {
                        alert('更新失败', 'infoEdit');
                    }
                }
            }
        }
    }



}
