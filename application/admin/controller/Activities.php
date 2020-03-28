<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/20
 * Time: 15:49
 */
namespace app\admin\controller;
use app\common\controller\AdminBase;
use app\common\model\Activities as ActivitiesModel;
use think\Config;
use think\Db;
/*
 * 广告管理
 * */
class Activities extends AdminBase{

        public function index($page=0){
            $ActivitiesList =  ActivitiesModel::paginate(15,false);
            $this->assign('ActivitiesList',$ActivitiesList);
            return $this->fetch();
        }

        public function add(){
            return $this->fetch();
        }

        public function edit(){
            return $this->fetch();
        }

        public function save(){

        }

        public function update(){

        }
}