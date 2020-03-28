<?php
namespace app\admin\controller;

use app\common\model\Custom as CustomModel;
use app\common\model\Kefu; //客服
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 商品管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Custom extends AdminBase
{

   public function edit()
   {
	$where['id'] = '1';
    $data = Kefu::where($where)->find();
    return $this->fetch('',['data'=>$data]);
   }


   public function update()
   {    
		$where['id'] = '1';
		$data = $this->request->post();
	
		$success = Kefu::where($where)->update($data);
		if ($success) {
		   return $this->success('修改成功');
		}else{
			return $this->error('修改失败,请重试');
		}
   }

}
