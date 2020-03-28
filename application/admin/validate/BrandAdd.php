<?php
namespace app\admin\validate;

use think\Validate;

class BrandAdd extends Validate
{
    protected $rule = [
        'name'  => 'require|unique:brand',
    ];

    protected $message = [
        'name.require'  => '请输入品牌名',
        'name.unique' => '品牌名已存在',
    ];
}