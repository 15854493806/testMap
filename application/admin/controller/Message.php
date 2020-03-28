<?php
namespace app\admin\controller;

use app\common\model\Message as MessageModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 资讯管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Message extends AdminBase
{
    protected $message_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->message_model = new MessageModel();
    }



    /**
     * 添加资讯
    */
   public function add()
   {    
        
      return $this->fetch('');
   }


   /*
   *接受表单的数据
    */
   public function save()
   {
      $data = $this->request->post();
      if (!$data['title']) {
          $this->error('请输入资讯标题');
      }
      $data['time'] = time();
      $success =$this->message_model->allowField(true)->save($data);
      if ($success) {
         $this->success('添加成功');
      }else{
          $this->error('添加失败');
      }
   }
 


   /*
   *浏览商品
    */
   public function index($keyword = '', $page = 1)
   {
      $data = $this->message_model::select();
      return $this->fetch('',['data'=>$data]);
   }



   public function edit($id)
   {
   		$message = MessageModel::where('id',$id)->select();
     	$message[0]['content'] = htmlspecialchars_decode($message[0]['content']);
     	return $this->fetch('',['data'=>$message[0]]);
   }


   public function update()
   {    
     $data = $this->request->post();
     if ($data) {
        $success = MessageModel::where('id',$data['id'])->update($data);
        if ($success) {
           return $this->success('修改成功');
        }else{
            return $this->error('修改失败,请重试');
        }
     }

   }


   public function delete($id)
   {
        $success = MessageModel::where('id',$id)->delete();
        if ($success) {
            return $this->success('删除成功');
        }else{
            return $this->error('删除失败,请重试');
        }
   }
}
