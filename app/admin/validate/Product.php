<?php
namespace app\admin\validate;

use think\Validate;

class Product extends Validate
{
    //这里是需要验证的键名和验证规则，require非空   max：25 最多不超过25字符
    protected $rule =   [
        'title'  => 'require|max:25',
        'desc'   => 'require',
    ];

    //这里是验证不通过的提示文本，通过实例化后的变量->方法 $validate->getError()返回。
    protected $message  =   [
        'title.require' => '产品名称不能为空',
        'title.max'     => '名称最多不能超过25个字符',
        'desc'   => '产品描述不能为空',
    ];

}