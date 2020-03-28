<?php
namespace app\admin\controller;

use app\common\model\Example as ExampleModel;
use app\common\controller\AdminBase;
use think\Db;

header('Access-Control-Allow-Origin:*');
/**
 * 添加景区
 * Class Spot
 * @package app\admin\controller
 */
class Spot extends AdminBase
{

    /**
     * 添加景区
     * @param string $cid
     * @return mixed
     */
    public function add()
    {
         $example = ExampleModel::select();
         return $this->fetch('',['example'=>$example]);
    }
	public function getCityimg($id){
    	if($id){
          	$where['id'] = $id;
        	$example = ExampleModel::where($where)->select();
          	return json($example[0]['img']);
        }
    }
   
}