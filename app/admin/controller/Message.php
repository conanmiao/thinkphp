<?php
namespace app\admin\controller;
use app\common\controller\Common;
use think\Db;

class Message extends Common
{
    /*用户留言列表页*/
    public
    function message()
    {
        $res = Db::table('message')
            ->order(['createtime' => 'DESC'])
            ->paginate(15);
        $this->assign('data', $res);
        return $this->checkLogin('message');
    }

    /*用户留言详情页*/
    public
    function msgDetail()
    {
//判断是否有GET id值，若有值则从数据库取出相应的值，准备填入input等标签
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $id = intval($_GET['id']);
            $res = Db::table('message')->where(['id' => $id])->find();
            if ($res && !empty($res)) {
                foreach ($res as $key => $val) {
                    $data["$key"] = $val;
                }
            }
        } else {
            return $this->fetch('message');
        }
        $this->assign('data', $data);
        return $this->checkLogin('msgDetail');
    }

    /*留言删除*/
    public function msgDel()
    {
        if ($this->noLogin()) {
            return $this->fetch('login');
        } else {
            if (isset($_GET['id']) && intval($_GET['id']) > 0) {
                $id = intval($_GET['id']);
                $res = model('Message')->destroy($id);
                if ($res) {
                    alert('删除成功', 'message');
                } else {
                    alert('删除失败', 'message');
                }
            } else {
                alert('ID错误', 'message');
            }
        }
    }
}