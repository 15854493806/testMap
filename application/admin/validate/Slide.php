<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 轮播图验证器
 * Class Slide
 * @package app\admin\validate
 */
class Slide extends Validate
{
    protected $rule = [
    'name' => 'require',
    'img' => 'require'
];

    protected $message = [
        'name.require' => '请输入名称',
        'img.require' => '请上传地图图片'
    ];
}