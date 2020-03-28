<?php
namespace app\api\controller;

require_once 'vendor/aliyuncs/oss-sdk-php/autoload.php';
use think\Controller;
use think\Session;
use app\common\model\System as SystemModel;
use OSS\OssClient;
use OSS\Core\OssException;
/**
 * 通用上传接口
 * Class Upload
 * @package app\api\controller
 */
class Upload extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();
        if (!Session::has('admin_id')) {
            $result = [
                'error'   => 1,
                'message' => '未登录'
            ];

            return json($result);
        }
    }

    /**
     * 通用图片上传接口
     * @return \think\response\Json
     */
    public function upload()
    {
        $config = [
            'size' => 2097152,
            'ext'  => 'jpg,gif,png,bmp'
        ];

        $file = $this->request->file('file');

        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads');
        $save_path   = 'public/uploads/';
        $info        = $file->validate($config)->move($upload_path);
        $system = SystemModel::find(1);
        if ($system->status == 1) {
            $path = $filepath =str_replace('\\', '/', $upload_path.'/'.$info->getSaveName());;
            $savename =  time();
            $accessKeyId = $system->KeyID;                       // Access Key ID
            $accessKeySecret = $system->KeySecret;               // Access Key Secret
            $endpoint = $system->Endpoint;                       // 阿里云oss 外网地址endpoint
            $bucket = $system->Bucket;                           // Bucket名称
            halt($path);
            try {
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                $result = $ossClient->uploadFile($bucket, $savename, $filepath);
                $result = [
                    'error' => 0,
                    'url'   => $result['info']['url']
                ];
            } catch (OssException $e) {
                $result = [
                    'error'   => 1,
                    'message' => $e->getMessage()
                ];
            }
            unset($info);
            unlink('.'.$path);
        }else{
            if ($info) {
                $result = [
                    'error' => 0,
                    'url'   => str_replace('\\', '/', $save_path . $info->getSaveName())
                ];
            } else {
                $result = [
                    'error'   => 1,
                    'message' => $file->getError()
                ];
            }
        }
        return json($result);
    }
  	

}