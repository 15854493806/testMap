<?php
namespace app\common\model;

use think\Model;

class Example extends Model
{
  /**
     * 获取层级缩进列表数据
     * @return array
     */
    public function getLevelList()
    {
        $category_level = $this->order(['id' => 'DESC'])->select();

        return array2level($category_level);
    }

}