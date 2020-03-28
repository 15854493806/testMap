<?php
namespace app\admin\controller;

use app\common\model\Brand as BrandModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 
 * @package app\admin\controller
 */
class Brand extends AdminBase
{
    protected $brand_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->brand_model = new BrandModel();
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
        $validate_result = $this->validate($data, 'BrandAdd');
        if ($validate_result !== true) {
           $this->error($validate_result);
        }else{
          $img = $this->request->post('img');
          if (!$img) {
            $this->error('请上传品牌标志');
          }
          $success = $this->brand_model->save($data);
          if ($success) {
              $this->success('添加成功');
          } else {
              $this->error('添加失败');
          }
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
        $brand_list = $this->brand_model->where($map)->order('id DESC')->paginate(15, false, ['page' => $page]);

        return $this->fetch('index', ['brand_list' => $brand_list, 'keyword' => $keyword]);
    
   }

   /*
   *  修改页面
   */

   public function edit($id)
   {
      $data = $this->brand_model::find($id);
      return $this->fetch('',['data'=>$data]);
   }

    /*
   *  执行修改
   */
  
  public function update()
  {
    
    $data = $this->request->post();
    $file = $this->brand_model::find($data['id']);
    $validate_result = $this->validate($data, 'BrandAdd');
    if ($validate_result !== true) {
       $this->error($validate_result);
    }else{
        $success = $this->brand_model->where('id',$data['id'])->update($data);
        if ($success) {
          $this->success('修改成功');
        }else{
          $this->error('修改失败');
        }

    }
  }

  /*
   *  执行删除
   */
  
  public function delete($id)
  {
    $file = $this->brand_model::find($id);
    $url = parse_url($file['img']);
    $unlink = unlink('.'.$url['path']);
    if ($this->brand_model->destroy($id)&&$unlink) {
        $this->success('删除成功');
    } else {
        $this->error('删除失败');
    }
  }


}