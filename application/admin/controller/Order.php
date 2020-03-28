<?php
namespace app\admin\controller;

use app\common\model\Order as OrderModel;
use app\common\controller\AdminBase;
use app\common\model\Pay;
use app\common\model\User;
use app\common\model\Good;
use app\common\model\Useraddress;
use app\common\model\Express;
use think\Config;
use think\Db;
use think\Request;

/**
 * 订单管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Order extends AdminBase
{
    /**
     * 显示订单
    */
   public function index($keyword = '', $page = 1)
   {    
     	$map = [];
        if ($keyword) {
            $map['orderid'] = ['like', "%{$keyword}%"];
        }
        $data = Pay::where($map)->paginate(15, false, ['page' => $page]);
		if($data){
			$count = count($data);
			for($i=0;$i<$count;$i++){
				// 根据uid查询用户名
				$user = User::where('id',$data[$i]['uid'])->find();
				$data[$i]['user'] = $user['name'];
				// 根据goodid查询商品名称
				$goodid = json_decode($data[$i]['goodid']);
				$number = json_decode($data[$i]['number']);
				$good = Good::where('id','in',$goodid)->select();
				// 将查到的商品名称和数量进行拼接
				$good_count = count($good);
				$good_info = [];
				for($y=0;$y<$good_count;$y++){
					$title = $good[$y]['title'];
					$good_number = $number[$y];
					$goodinfo = $title.'&nbsp;&nbsp;&nbsp;*'.$good_number;
					array_push($good_info,$goodinfo);
				}
				$data[$i]['good'] = $good_info;
				// 根基aid查询收货人和地址
				$address = Useraddress::where('id',$data[$i]['aid'])->find();
				$data[$i]['uid'] = $address['name'];
				$data[$i]['phone'] = $address['phone'];
				$data[$i]['aid'] = $address['shengshi'].$address['address'];
				// 根基express查询快递
				if($data[$i]['express']){
					$express = Express::where('id',$data[$i]['express'])->find();
					$data[$i]['kuaidi'] = $express['express'];
				}
			}
		}
		
        return $this->fetch('',['data'=>$data]);
   }
   
	public function edit($id)
   {
    $express = Express::select();
    return $this->fetch('',['express'=>$express,'id'=>$id]);
   }
   public function editfahuo($id)
   {
    $express = Express::select();
	$data = Pay::where('id',$id)->find();
    return $this->fetch('',['express'=>$express,'id'=>$id,'data'=>$data]);
   }
	public function fahuo()
   {
    $data = $this->request->post();
    if ($data) {
		$data['status'] = '3';
        $success = Pay::where('id',$data['id'])->update($data);
        if ($success) {
           return $this->success('快递信息已录入');
        }else{
            return $this->error('操作失败,请重试');
        }
    }
   }
}