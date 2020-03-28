<?php


namespace app\common\model;


use think\Model;

class Newscenic extends Model {

    protected $resultSetType = 'collection';

    public function getImgAttr($value){
        return explode(',',$value);
    }
}