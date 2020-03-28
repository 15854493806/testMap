<?php
namespace app\index\controller;

use app\common\controller\HomeBase;

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Headers:x-requested-with,content-type,USER_ID,TOKEN');
header("content-type:text/html;charset=utf-8");

class IndexCopy extends HomeBase
{
    public function  index(){
        return $this->fetch("index");
    }
}
















