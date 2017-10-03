<?php
namespace app\api\controller;
use think\controller;

class Index extends Controller
{
    public function index(){
//        return 'holle world!';
        return [
            'username'=>'caogu',
            'age'=>28,
            'email'=>'conanmiao@qq.com'
        ];
    }

    public function test(){
        return [
            'this is api index test',
            'oh yes'
        ];
    }

    public function postTest(){
        $id=isset($_POST['id'])?$_POST['id']:0;
        return [
            'this is api index postTest',
            $id
        ];
    }
}