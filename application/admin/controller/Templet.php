<?php
namespace app\admin\controller;

use app\common\model\Templet as TempletModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 主图模板管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Templet extends AdminBase
{
    protected $templet_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->templet_model = new TempletModel();
    }

   /*
   *模板列表
    */
   public function index($keyword = '', $page = 1)
   {
        $field=[
          id,	
          name,
          video,
          img
        ];
     	if($keyword){
        	$where['name'] = ['like','%'.$keyword.'%'];
            $data =$this->templet_model
                ->field($field)
                ->where($where)
                ->order('id','DESC')
                ->paginate(15, false, ['page' => $page]);        	
        }else{
        	$data =$this->templet_model
                ->field($field)
                ->order('id','DESC')
                ->paginate(15, false, ['page' => $page]);
        }
     	if($data){
        	$count = count($data);
          	for($i=0;$i<$count;$i++){
                $data[$i]['img'] = explode(",",$data[$i]['img']);
            }
        }
        return $this->fetch('',['data'=>$data]);
   }
	public function add(){
    	
    	return $this->fetch();
    
    }
  	public function save(){
      $data = $this->request->post();
      $file = $this->request->file('video');
      if(!empty($file)) {
       	 $info = $file->move('./public/video/');
       	 if($info){
       	   $data['video'] ='/public/video/'.$info->getSaveName();
       	 }else{
        	  $this->error('视频上传失败');
         }
      }
      $data['img'] = implode(",",$data['img']);
      $success = $this->templet_model->allowField(true)->save($data);
        if ($success) {
           return $this->success('添加成功');
        }else{
            return $this->error('添加失败,请重试');
        }
   }


   public function edit($id)
   {
    $data = TempletModel::where('id',$id)->select();
    var_dump($data);die;
    return $this->fetch('edit',['data'=>$data]);
   }


   public function update()
   {    
     $data = $this->request->post();
     if ($data) {
        $success = GoodModel::where('id',$data['id'])->update($data);
        if ($success) {
           return $this->success('修改成功');
        }else{
            return $this->error('修改失败,请重试');
        }
     }

   }


   public function delete($id)
   {
        $success = TempletModel::where('id',$id)->delete();
        if ($success) {
            return $this->success('删除成功');
        }else{
            return $this->error('删除失败,请重试');
        }
   }
}
