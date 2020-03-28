<?php
namespace app\admin\validate;

use think\Validate;

class UserUpdata extends Validate
{
    protected $rule = [
        'username'         => 'require|unique:user|max:25',
        'password'         => 'confirm',
        'mobile'           => 'number|length:11|unique:user|require',
        'buy_time'         => 'require',
        'buy_type'         => 'require',
        'buy_mark'         => 'require'

    ];

    protected $message = [
        'username.require'         => '请输入用户名',
        'username.unique'          => '用户名已存在',
        'username.max'             => '用户名最多为25个字符',
        'password.confirm'         => '两次输入密码不一致',
        'mobile.require'           => '请输入手机号',
        'mobile.number'            => '手机号格式错误',
        'mobile.unique'            => '手机号已被注册',
        'mobile.length'            => '手机号长度错误',
        'buy_time.require'         => '请选择购车时间',
        'buy_type.require'         => '请选择汽车型号',
        'buy_mark.require'         => '请输入汽车牌照'
        
    ];
}