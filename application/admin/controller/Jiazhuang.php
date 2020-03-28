<?php
namespace app\admin\controller;
use think\Config;
use think\Db;
use app\common\controller\AdminBase;
/*
 * 广告管理
 * */
class Jiazhuang extends AdminBase{
      public function index($page = 1){
        
            $infor  = Db::table('os_install')->paginate(15, false, ['page' => $page]);
            if(input('get.dizhi')){
               $dizhi = input('get.dizhi');
               $where['sheng'] = array('like','%'.$dizhi.'%');
               $infor  = Db::table('os_install')->where($where)->paginate(100, false, ['page' => $page]);
            }
            return $this->fetch('index',['infor'=>$infor]);
      }
      public function add(){
         $public = PUBLICS;
          return $this->fetch('add',['public'=>$public]);
      }
      
}