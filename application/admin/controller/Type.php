<?php
namespace app\admin\controller;

use app\common\model\Type as TypeAddModel;
use app\common\model\Brand as BrandModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 型号管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Type extends AdminBase
{
    protected $type_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->type_model = new TypeAddModel();
    }




    /*
    * 渲染添加页面
    */
    public function add()
    {
        $data = BrandModel::select();
        return $this->fetch('',['data'=>$data]);
    }    

    /*
    * 接受表单提交的数据
    */
   
   public function save()
   {
        $data = $this->request->post();
        if (!$data['name']) {
            $this->error('请输入车型名称');
        }
       if (!$data['img']) {
              $this->error('请上传车型标志');
          }
        if ($this->type_model->save($data)) {
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
   }


    /*
    * 查看列表
    */
  public function index($keyword = '', $page = 1)
   {

    $field = [
        't.id',
        't.name',
        'b.name as pname',
        't.img',
        't.create_time'
    ];
    $map = [];
        if ($keyword) {
            $map['t.name'] = ['like', "%{$keyword}%"];
    }
     $data  = $this->type_model::alias('t')
            ->join('_Brand_ b','t.pid = b.id')
            ->field($field)
            ->where($map)
            ->order('id DESC')
            ->paginate(15, false, ['page' => $page]);
    return $this->fetch('',['data'=>$data]);
   }


    /*
    * 修改界面
    */

    public function edit($id)
    {   
        $brand = BrandModel::select();
        $data = $this->type_model::find($id);
        return $this->fetch('',['data'=>$data,'brand'=>$brand]);
    }

    /*
    * 执行修改
    */
   
   public function update()
   {
        $data = $this->request->post();
        if (!$data['name']) {
            $this->error('请输入车型名称');
        }
        if (!$data['img']) {
            $this->error('请上传车型标志');
        }
        if($this->type_model::where('id',$data['id'])->update($data)){
                $this->success('修改成功');
        }else{
                $this->error('修改失败');
        }

   }
   

    /*
    * 执行删除
    */
   public function delete($id)
   {
       if ($this->type_model::destroy($id)) {
            $this->success('删除成功');
       }else{
            $this->error('删除失败');
       }
   }
}