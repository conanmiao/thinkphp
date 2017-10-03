<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    //这里是需要验证的键名和验证规则，require非空   max：25 最多不超过25字符
    protected $rule =   [
        'username'  => 'require|max:16',
        'password'   => 'require',
    ];

    //这里是验证错误信息，通过实例化后的变量->方法 $validate->getError()返回，返回类型为字符串。
    protected $message  =   [
        'username.require' => '账号不能为空',
        'username.max'     => '账号不能超过16个字符',
        'password.require'   => '密码不能为空',
    ];

}