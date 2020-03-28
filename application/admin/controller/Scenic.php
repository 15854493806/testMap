<?php
namespace app\admin\controller;

use app\common\model\Scenic as ScenicModel;
use app\common\model\Example; //地区
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 商品管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Scenic extends AdminBase
{
    protected $scenic_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->scenic_model = new ScenicModel();
    }

    public function add(){
        return $this->fetch();
    }


   /*
   *接受表单的数据
    */
   public function save()
   {
      $data = $this->request->post();
      $data['img'] = implode(",",$data['img']);
      $success = $this->scenic_model->allowField(true)->save($data);
      if ($success) {
        return $this->success('添加成功');
      }else{
        return $this->error('添加失败,请重试');
      }
   }

   public function NewSave(){
       if($this->request->isPost()){
           $data = $this->request->post();
           $data['img'] = implode(",",$data['img']);
           $data['create_time'] = date('Y-m-d H:i:s');
           $data['update_time'] = date('Y-m-d H:i:s');
           $success = $this->scenic_model->allowField(true)->save($data);
           if ($success) {
               return $this->success('添加成功');
           }else{
               return $this->error('添加失败,请重试');
           }
       }
   }

   /*
   *浏览商品
    */
   public function index($keyword = '', $page = 1)
   {
     	$map = [];
        if ($keyword) {
            $map['s.name'] = ['like', "%{$keyword}%"];
        }
        $field=[
            'c.name as cname',
            's.name as sname',
            's.id',
          	's.img',
          	's.content',
          	's.hits'
        ];
        $data = ScenicModel::alias('s')
          		->join('_Example_ c','s.cid=c.id')
                ->field($field)
          		->where($map)
                ->order('id','DESC')
                ->paginate(15, false, ['page' => $page]);
        return $this->fetch('',['data'=>$data]);
   }



   public function edit($id)
   {
    $scenic = $this->scenic_model->find($id);
	$map = Example::select();
    $where['id'] = $scenic['cid'];
    $img = Example::field('img')->find();
    $scenic['img'] = explode(',',$scenic['img']);
    return $this->fetch('edit',['scenic'=>$scenic,'map'=>$map,'img'=>$img]);
   }


   public function update()
   {    
     $data = $this->request->post();
     unset($data['editorValue']);
     $data['img'] = implode(",",$data['img']);
     if ($data) {
        $success = ScenicModel::where('id',$data['id'])->update($data);
        if ($success) {
           return $this->success('修改成功');
        }else{
            return $this->error('修改失败,请重试');
        }
     }
   }


   public function delete($id)
   {
        $success = ScenicModel::where('id',$id)->delete();
        if ($success) {
            return $this->success('删除成功');
        }else{
            return $this->error('删除失败,请重试');
        }
   }
}
