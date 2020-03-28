<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use app\common\model\Example as ExampleModel;
use app\common\model\Scenic as ScenicModel;
use think\Db;

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Headers:x-requested-with,content-type,USER_ID,TOKEN');
header("content-type:text/html;charset=utf-8");
/**
 * 景区相关接口
 * Class Spot
 * @package app\admin\controller
 */
class Spot extends HomeBase
{
  	public function getScenic($cid = 1,$pid = 1){
      	$where_example['id'] = $cid;
      	$field = [img,name,url];
      	$data = ExampleModel::field($field)->where($where_example)->find();
        $where['cid'] = $cid;
        $where['classid'] = $pid;
        $field = [id,coordinate_left,coordinate_top,name];
        $example = ScenicModel::field($field)->where($where)->select();
      	$img = 'http://'.$_SERVER['SERVER_NAME'].$data['img'];
      	$url = str_replace('&quot;','"',$data['url']);
      	
        return json(array('Status' => 0,'Message' => '查询成功','Img' => $img,'Name' => $data['name'],'Url' => $url,'Data' => $example));
    }
  	public function getScenicDetails($id){
    	if($id){
          	$where['id'] = $id;
          	$field = [name,img,content];
        	$example = ScenicModel::field($field)->where($where)->find();
            $example[img] = explode(",",$example[img]);
          	$example['url'] =  'http://'.$_SERVER['SERVER_NAME'];
          	$content = htmlspecialchars_decode($example['content']);
            $example['content'] = $content;
          	return json(array('Status' => 0,'Message' => '查询成功','Data' => $example));
        }else{
          	return json(array('Status' => 0,'Message' => '缺少参数信息'));
        }
    }
	public function getCityimg($id){
    	if($id){
          	$where['id'] = $id;
        	$example = ExampleModel::where($where)->select();
          	return json(array('Status' => 1,'Message' => '查询成功','Data' => $example[0]['img']));
        }
    }
   	
}