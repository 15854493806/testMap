<?php
namespace app\admin\controller;
use app\common\model\Answer as AnswerModel;
use app\common\model\Wenti; //商品分类
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 商品管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Answer extends AdminBase
{
	/*
   *浏览商品
    */
   public function index($page = 1)
   {
        $data = Wenti::order('id','DESC')->paginate(15, false, ['page' => $page]);
        return $this->fetch('',['data'=>$data]);
   }

    /**
     * 添加商品
    */
   public function add()
   {    
         return $this->fetch();
   }


   /*
   *接受表单的数据
    */
   public function save()
   {
        $data = $this->request->post();	
     	$wenti = new Wenti();
		$success = $wenti->allowField(true)->save($data);
        if ($success) {
           $this->success('添加成功');
        }else{
           $this->error('添加失败');
        }
   }
   
   public function edit($id)
   {
	$where['id'] = $id;
    $data = Wenti::where($where)->find();
    return $this->fetch('',['data'=>$data]);
   }


   public function update()
   {    
		$where['id'] = $this->request->post('id');
		$data = $this->request->post();
	
		$success = Wenti::where($where)->update($data);
		if ($success) {
		   return $this->success('修改成功');
		}else{
			return $this->error('修改失败,请重试');
		}
   }
  
  public function delete($id)
   {
        $success = Wenti::where('id',$id)->delete();
        if ($success) {
            return $this->success('删除成功');
        }else{
            return $this->error('删除失败,请重试');
        }
   }
}
