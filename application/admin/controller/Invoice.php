<?php
namespace app\admin\controller;

use app\common\model\Invoice as InvoiceModel;
use app\common\model\User;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 用户管理
 * @package app\admin\controller
 */
class Invoice extends AdminBase
{
    protected $invoice_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->invoice_model = new InvoiceModel();
    }

   /*
   *渲染添加发票页面
   */
   public function add()
   {
        return $this->fetch();
   }

   /*
   *  接受添加发票的表单信息
   */
   public function save()
   {    
        $data = $this->request->post();
        $success = $this->invoice_model->allowField(true)->save($data);
        if ($success) {
            $this->success('添加成功');
        } else {
            $this->error('添加失败');
        }
   }

   /*
   *  浏览发票信息
   */
   public function index($keyword = '', $page = 1)
   {

    $field = [
        'i.id',
        'i.name',
        'i.identify',
        'i.site',
        'i.phone',
        'i.bank',
        'i.number',
        'i.status',
        'u.username'
    ];
    $map = [];
        if ($keyword) {
            $map['u.username'] = ['like', "%{$keyword}%"];
    }
     $data  = $this->invoice_model::alias('i')
            ->join('_User_ u','i.uid = u.id')
            ->field($field)
            ->where($map)
            ->order('id DESC')
            ->paginate(15, false, ['page' => $page]);
     return $this->fetch('',['data'=>$data]);
   }

   /*
   *  修改审核状态
   */

   public function edit($id,$status)
   {
     	if($status == 1){
          $success = $this->invoice_model::where('id',$id)->update(['status'=>1]);
          if ($success) {
            return  $this->success('已通过');
          } else {
             return $this->error('修改失败');
          }
        }
     if($status == 2){
          $success = $this->invoice_model::where('id',$id)->update(['status'=>2]);
          if ($success) {
            return  $this->success('已拒绝');
          } else {
            return  $this->error('修改失败');
          }
        }
   }
  
  // 重置
  public function reset($id)
   {
     	if($id){
          $success = $this->invoice_model::where('id',$id)->update(['status'=>0]);
          if ($success) {
            return  $this->success('已通过');
          } else {
             return $this->error('修改失败');
          }
        }
   }
  
}