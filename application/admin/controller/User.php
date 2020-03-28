<?php
namespace app\admin\controller;

use app\common\model\User as UserModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use think\Request;

/**
 * 用户管理
 * Class AdminUser
 * @package app\admin\controller
 */
class User extends AdminBase
{
    protected $user_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->user_model = new UserModel();
    }

    /**
     * 用户管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
        $map = [];
        if ($keyword) {
            $map['nickname'] = ['like', "%{$keyword}%"];
        }
        $user_list = $this->user_model->where($map)->order('id DESC')->paginate(15, false, ['page' => $page]);

        return $this->fetch('index', ['user_list' => $user_list, 'keyword' => $keyword]);
    }

    /**
     * 添加用户
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 保存用户
     */
    public function save()
    {

        
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'User');
           if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $data['password'] = md5($data['password'] . Config::get('salt'));
                $data['create_time'] = time();
                $file = $this->request->file('photo');
                if ($file) {
                    $info = $file->move('./public/uploads');
                    $data['photo'] = 'http://'.$_SERVER['SERVER_NAME'].'/public/uploads/'. $info->getSaveName(); 
                }
                $success = $this->user_model->allowField(true)->save($data);
                if ($success) {
                    $this->success('添加成功');
                } else {
                    $this->error('添加失败');
                }
            }
        }
    }

    /**
     * 编辑用户
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = $this->user_model->find($id);

        return $this->fetch('edit', ['user' => $user]);
    }

    /**
     * 更新用户
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'UserUpdata');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {

                $user           = $this->user_model->find($id);
                $user->id       = $id;
                $user->username = $data['username'];
                $user->mobile   = $data['mobile'];
                $user->buy_time   = $data['buy_time'];
                $user->buy_type   = $data['buy_type'];
                $user->buy_mark   = $data['buy_mark'];

                if (!empty($data['password']) && !empty($data['confirm_password'])) {
                    $user->password = md5($data['password'] . Config::get('salt'));
                }
                $file = $this->request->file('photo');
                if ($file) {
                    $info = $file->move('./public/uploads');
                    $user->photo = 'http://'.$_SERVER['SERVER_NAME'].'/public/uploads/'. $info->getSaveName(); 
                }
                if ($user->save() !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            }
        }
    }

    /**
     * 删除用户
     * @param $id
     */
    public function delete($id)
    {
        if ($this->user_model->destroy($id)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}