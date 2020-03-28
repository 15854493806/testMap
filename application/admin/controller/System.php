<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Cache;
use think\Db;
use app\common\model\System as SystemModel;
/**
 * 系统配置
 * Class System
 * @package app\admin\controller
 */
class System extends AdminBase
{
    public function _initialize(){
        parent::_initialize();
    }

    /**
     * 站点配置
     */
    public function  index(){
        $System = SystemModel::find();
        $this->assign("System",$System);
        return $this->fetch("index");
    }


    /**
     * 更新配置
     */
    public function update()
    {
        if ($this->request->isPost()) {
            $site_config                = $this->request->post();
            if (SystemModel::where("id",1)->update($site_config) !== false) {
                $this->success('更新成功');
            } else {
                $this->error('啊啊啊~失败啦!!~~');
            }
        }
    }

    /**
     * 清除缓存
     */
    public function clear()
    {
        if (delete_dir_file(CACHE_PATH) || delete_dir_file(TEMP_PATH)) {
            $this->success('清除缓存成功');
        } else {
            $this->error('清除缓存失败');
        }
    }
}