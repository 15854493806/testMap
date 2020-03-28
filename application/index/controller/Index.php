<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use app\common\model\Newscenic;
use app\common\model\User;
use app\common\model\CollectionUser;
use think\Cookie;
use think\Request;

header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Headers:x-requested-with,content-type,USER_ID,TOKEN');
header("content-type:text/html;charset=utf-8");

class Index extends HomeBase
{
    protected $uid;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if($this->openID){
            $where["openid"] = $this->openID;
            $this->uid = User::where($where)->value('id');
        }else
            $this->uid = $this->request->param('uid')?:19;
    }

    public function  index(){
        return $this->fetch();
    }
  	//城市页面
  	public function drive(){
    	return $this->fetch();
    }	
  
  	//收藏
  	public function mark(){
    	return $this->fetch();
    }
    //获取不同classId 的景点
    public function getList($class = 1,$key = ''){
        $markList = Newscenic::where('classid',$class)
            ->whereLike('name_cn|name_kr','%'.$key.'%')
            ->field('id,name_cn,name_kr,lon,lat')
            ->select();
        return json(['Code'=>200,'Msg'=>'获取成功','data'=>$markList]);
    }

    public function getDeatils($id){
        $data = Newscenic::find($id);
        $data['type'] = CollectionUser::where(['uid'=>$this->uid,'sid'=>$id])->find()?1:0;
      	$data['content_cn'] = htmlspecialchars_decode($data['content_cn']); 
        $data['content_kr'] = htmlspecialchars_decode($data['content_kr']); 
        return json(['Code'=>200,'Msg'=>'获取成功','data'=>$data]);
    }

  	//获取城市列表
  	public function getCity(){
    	$cityList = Newscenic::Distinct(true)->field('city')->order('city desc')->select();
      	return json(['Code'=>200,'Msg'=>'获取成功','data'=>$cityList]);
    }
  
  	public function getmark(){
        $map['C.uid'] = $this->uid;
        $list = CollectionUser::alias('C')
            ->join('_Newscenic_ n','n.id = C.sid')
      		->where($map)
            ->field('C.id,C.sid,C.note,n.name_cn,n.name_kr,n.img')
            ->select();
         return json(['Code'=>200,'Msg'=>'获取成功','data'=>$list]);
    }
  
    //添加收藏
  	public function marks(){
      if($this->request->isPost()){
        $map['uid'] =  $this->uid;
        $map['sid'] = $this->request->post('sid');
      	$info = CollectionUser::where($map)->find();
        if($info)
          	   return json(['Code'=>0,'Msg'=>'收藏失败,景点已收藏']);
      	if((new CollectionUser)->create($map))
              return json(['Code'=>200,'Msg'=>'收藏成功']);
        else
              return json(['Code'=>0,'Msg'=>'收藏失败']);   
      }
    }
  	//更新收藏
  	public function updatemarks(){
      if($this->request->isPost()){
        $map['uid'] =  $this->uid;
        $id =   $this->request->post('id');
        $map['sid'] = $this->request->post('sid');
        $map['note'] = $this->request->post('note');
        if(mb_strlen($map['note'])>120)
            return json(['Code'=>0,'Msg'=>'备注最多120个字']); 
      	$info = CollectionUser::where($map)->find();
      	if((new CollectionUser())->allowField(true)->save($map,['id'=>$id]))
              return json(['Code'=>200,'Msg'=>'收藏成功']);
        else
              return json(['Code'=>0,'Msg'=>'收藏失败']);   
      }
    }
    //删除收藏
    public function delmarks(){
    	if($this->request->isPost()){
         $map['uid'] =  $this->uid;
        $map['id'] =   $this->request->post('id');
      	$info = CollectionUser::where($map)->find();
      	if($info){
       		 if(CollectionUser::where('id',$info->id)->delete())
               return json(['Code'=>200,'Msg'=>'删除成功']); 
        }
        return json(['Code'=>0,'Msg'=>'删除收藏失败']); 
      }
    }
    public function getBanner(){
        return json(['Code'=>200,'Msg'=>'获取成功','Img'=>'http://www.baidu.com/img/baidu_jgylogo3.gif','Url'=>'http://www.baidu.com']);
    }
}
















