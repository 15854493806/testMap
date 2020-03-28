<?php
namespace app\admin\controller;

use app\common\model\Example as ExampleModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 案例
 * Class Slide
 * @package app\admin\controller
 */
class Example extends AdminBase
{

    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 案例管理
     * @return mixed
     */
    public function index()
    {
        $example_list           = ExampleModel::all();

        return $this->fetch('index', ['example_list' => $example_list]);
    }

    /**
     * 添加轮播图
     * @return mixed
     */
    public function add()
    {
        $slide_category_list = SlideCategoryModel::all();

        return $this->fetch('add', ['slide_category_list' => $slide_category_list]);
    }

    /**
     * 保存城市
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Slide');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $slide_model = new ExampleModel();
                if ($slide_model->allowField(true)->save($data)) {
                    $this->success('保存成功');
                } else {
                    $this->error('保存失败');
                }
            }
        }
    }

    /**
     * 编辑城市
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $example               = ExampleModel::get($id);

        return $this->fetch('edit', ['example' => $example]);
    }

    /**
     * 更新城市
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Slide');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $slide_model = new ExampleModel();
                if ($slide_model->allowField(true)->save($data, $id) !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除城市
     * @param $id
     */
    public function delete($id)
    {
        if (ExampleModel::destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}