<?php
namespace app\admin\validate;

use think\Validate;

class Menu extends Validate
{
    protected $rule = [
        'tid'   => 'require',
        'bid' => 'require',
        'pid'  => 'require',
      	'title'  => 'require',
      	'logoutprice'  => 'require',
      	'companyprice'  => 'require',
      	'Individualprice'  => 'require',
      	'kucun'  => 'require',
      	'guige'  => 'require',
      	'img'  => 'require',
      	'details'  => 'require'
    ];

    protected $message = [
        'tid.require'   => '请选择头图模板',
      	'bid.require'   => '请选择所属品牌',
      	'pid.require'   => '请选择所属车型',
      	'title.require'   => '请输入商品名称',
      	 'logoutprice.require'   => '请输入未登录价格',
      	'companyprice.require'   => '请输入公司价格',
      	'Individualprice.require'   => '请输入个人价格',
      	'kucun.require'   => '请输入库存',
      	 'guige.require'   => '请输入规格',
      	'img.require'   => '请上传缩略图',
      	'details.require'   => '请输入商品详情'
    ];
}