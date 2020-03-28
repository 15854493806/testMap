<?php
namespace app\common\controller;

use think\Cache;
use think\Controller;
use think\Cookie;
use think\Db;
use app\common\model\User as UserModel;
class HomeBase extends Controller
{
    protected $appId = "wx4c5d723b23acea37" ;
    protected $appSecret = "c5d5cef02fd16f89e5b82a82029b65a8";
    private $userModel;
    protected function _initialize()
    {
        parent::_initialize();
        $this->userModel = new UserModel;
    //    $this->checkUserInfo();

    }

    //用户获取微信网页授权
    private function Wx_redirect(){
           $appid = $this->appId;
           $Url = $this->request->domain().$this->request->baseUrl();
           $redirect_uri = urlencode($Url);//重定向地址
           $state = $this->createNonceStr(16);
           $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=".$state."#wechat_redirect";
           $this->redirect($url);
    }

    private  function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
          $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    //拉取微信用户详细信息
    private function getUserInfo($Code){
        $appid = $this->appId;
        $secret = $this->appSecret;
        $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$Code&grant_type=authorization_code";
        $oauth2 = $this->getJson($oauth2Url);


        // 获得 access_token 和openid,通过access_token和openid获取用户的信息
        $access_token = $oauth2["access_token"];
        $openid = $oauth2['openid'];
        $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $userinfo = $this->getJson($get_user_info_url);

        if(count($openid) != 0 &&  count($access_token) != 0){
            Cookie::set("OPENID",$openid);
            $where=["openid"=>$openid];

            $userinfo["accesstoken"] = $access_token;
            $userinfo["tokentime"] = time()+ 30 * 24 * 60 * 60;
            $userinfo["lasttime"] = time();

            if(UserModel::field("*")->where($where)->count()){
                $ret = $this->userModel->where($where)->allowField(true)->update($userinfo);
            }else{
                $userinfo["create_time"] = time();
                $ret = $this->userModel->allowField(true)->save($userinfo);
            }
        }
    }

    //获取用户信息
    private function checkUserInfo(){
        $Code = $this->request->get("code");
        if(!empty($Code))
            $this->getUserInfo($Code);
        else if(!empty(Cookie::get("OPENID"))){
            $this->refreshtoken();
        }else
            $this->Wx_redirect($Code);;

    }

    //拉取用户token
    private function refreshtoken(){
        $where["openid"] = Cookie::get("OPENID");
        $user = UserModel::where($where)->find();
        if(count($user)){
            if($user["tokentime"]<time()){
                $refresh_token_url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".$this->appId."&grant_type=refresh_token&refresh_token=".$user["accesstoken"];
                $tokenInfo = $this->getJson($refresh_token_url);
                $data["accesstoken"] = $tokenInfo["refresh_token"];
                $data["tokentime"] = time() + 30*24*60*60;
                $data["lasttime"] = time() ;
                $this->userModel->where($where)->allowField(true)->update($data);
            }else{
                $data["lasttime"] = time() ;
                $this->userModel->where($where)->update($data);
            }
        }else
            $this->getUserInfo($Code);

    }


    protected function getJson($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }
}
