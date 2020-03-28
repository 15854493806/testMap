<?php
namespace app\admin\controller;

use app\common\model\Goodclass as GoodclassModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 
 * @package app\admin\controller
 */
class Goodclass extends AdminBase
{
    protected $goodclass_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->goodclass_model = new GoodclassModel();
    }

   /*
   *渲染添加品牌页面
   */
   public function add()
   {
      return $this->fetch();
   }

   /*
   *  接受品牌添加界面的表单信息
   */
   public function save()
   {    
        $data = $this->request->post();
        $success = $this->goodclass_model->save($data);
        if ($success) {
            $this->success('添加成功');
        } else {
              $this->error('添加失败');
        }
        
   }

   /*
   *  浏览品牌信息
   */
   public function index($keyword = '', $page = 1)
   {

     $map = [];
        if ($keyword) {
            $map['name'] = ['like', "%{$keyword}%"];
        }
        $class = $this->goodclass_model->where($map)->order('id DESC')->paginate(15, false, ['page' => $page]);

        return $this->fetch('index', ['class' => $class, 'keyword' => $keyword]);
    
   }

   /*
   *  修改页面
   */

   public function edit($id)
   {
      $data = $this->goodclass_model->select($id);
      return $this->fetch('',['data'=>$data[0]]);
   }

    /*
   *  执行修改
   */
  
  public function update()
  {
    
    $data = $this->request->post();
	$success = $this->goodclass_model->where('id',$data['id'])->update($data);
	if ($success) {
	  $this->success('修改成功');
	}else{
	  $this->error('修改失败');
	}
  }

  /*
   *  执行删除
   */
  
  public function delete($id)
  {
    if ($this->goodclass_model->destroy($id)) {
        $this->success('删除成功');
    } else {
        $this->error('删除失败');
    }
  }


}