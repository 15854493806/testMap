<?php


namespace app\common\model;


use think\Model;

class CollectionUser extends Model {
    protected $resultSetType = 'collection';

    public function getImgAttr($value) {
        return explode(',',$value);
    }
}