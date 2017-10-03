<?php

namespace app\admin\controller;

use app\common\controller\Common;
use think\Validate;

class User extends Common
{

    public function userList()
    {
        if (isset($_get['keywords']) || !empty($_GET['keywords'])) {
            $keywords = input('get.keywords');
            $data = model('User')
                ->where('username', 'LIKE', "%$keywords%")
                ->paginate(10);
        } else {
            $data = model('User')->paginate(10);
        }
        $this->assign('data', $data);
        return $this->checkLogin('userList');
    }

    public function userEdit()
    {
        //初始化默认变量
        if (isset($_GET['id']) && intval($_GET['id']) > 0) {
            $id = input('get.id/d');
            $data = model('user')->find($id);
        } else {
            $data = array('username' => '', 'name' => '', 'tel' => '');
        }
        $this->assign('data', $data);
        return $this->checkLogin('userEdit');
    }

    public function userAdd()
    {
        return $this->checkLogin('userAdd');
    }


    public function doUserAdd()
    {
        if ($this->noLogin()) {
            return $this->fetch('/index/login');
        } else {
            //通过是否有getID来判断新增用户还是编辑用户
            if(isset($_GET['id'])&&intval($_GET['id'])>0){
                //编辑用户信息
                $id=input('get.id/d');
                $data = array(
                    'id'=>$id,
                    'username' => input('post.username'),
                    'name' => input('post.name'),
                    'tel' => input('post.tel'),
                );
                //验证规则
                $rule = [
                    'username'  => 'require|max:16',
                ];
                $msg = [
                    'username.require' => '账号不能为空',
                    'username.max'     => '账号不能超过16个字符',
                ];

                $validate = new validate($rule,$msg);//实例化验证器
                if (!$validate->check($data)) {
                    alert($validate->getError(),"userEdit?id=$id");
                }else{
                    $res = model('user')->update($data);
                    if ($res) {
                        alert('修改成功', 'userList');
                    } else {
                        alert('修改失败', 'userEdit');
                    }
                }

            }else{
                //新增用户
                $data = array(
                    'username' => input('post.username'),
                    'password' => md5(input('post.password')),
                    'name' => input('post.name'),
                    'tel' => input('post.tel'),
                    'create_time' => time()
                );
                $validate = validate('User');//实例化验证器
                if (!$validate->check($data)) {
                    alert($validate->getError(), 'userEdit');
                }else{
                    $res = model('user')->create($data);
                    if ($res) {
                        alert('创建成功', 'userList');
                    } else {
                        alert('创建失败', 'userEdit');
                    }
                }
            }
        }
    }

    public function userPassword()
    {
        $id=input('get.id/d');
        if($id==0){
            alert('id错误','userList');
        }else{
            $data=model('User')
                ->field('id','username')
                ->find($id);
            $this->assign('data',$data);
            return $this->checkLogin('userPassword');

        }
    }

    public function doUserPassword()
    {

        if ($this->noLogin()) {
            return $this->fetch('login');
        } else {
            if(!isset($_GET['id'])||intval($_GET['id'])==0){
                alert('ID错误','userList');
            }else{
                $id=input('get.id/d');
                if (empty($_POST['newPassword'])) {
                    alert('请输入新密码', "userPassword?id=$id");
                }
                $newPassword = md5(input('post.newPassword'));
                $newPassword2 = md5(input('post.newPassword2'));
                if ($newPassword !== $newPassword2) {
                    alert('两次密码不一致', "userPassword?id=$id");
                }
                $data = ['id'=>$id,'password' => $newPassword];
                $res = model('user')->update($data);
                if ($res) {
                    alert('修改成功', "userPassword?id=$id");
                } else {
                    alert('修改失败', "userPassword?id=$id");
                }
            }

        }
    }

    public function userDel()
    {
        if ($this->noLogin()) {
            return $this->fetch('login');
        } else {
            if (isset($_GET['id']) && intval($_GET['id']) > 0) {
                $id = input('get.id/d');
                $res = model("User")->destroy($id);
                if ($res) {
                    alert('删除成功', 'userList');
                } else {
                    alert('删除失败', 'userList');
                }
            } else {
                alert('ID错误', 'userList');
            }
        }
    }
}
