<?php

namespace App\Http\Controllers;

require base_path() . '/vendor/qiniu/php-sdk/autoload.php';
//base_path()获取 laravel 项目的根目录，引入 SDK

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Illuminate\Http\Request;

class QuniuServiceController extends Controller
{
    //
    protected $domain = null;
    protected $bucket = null;
    protected $accessKey = null;
    protected $secretKey = null;
    protected $auth;

    public function __construct()
    {
        $this->domain = config('app.QINIU_DOMAIN');
        $this->bucket = config('app.QINIU_BUCKET');
        $this->accessKey = config('app.QINIU_ACCESSKEY');
        $this->secretKey = config('app.QINIU_SECRETKEY');

        $this->auth = new Auth($this->accessKey, $this->secretKey); // 鉴权
    }

    public function upLoad($filePath)
    {
        $token = $this->getToken();
        //上传时会对比上传表单中 post 过来的 token 是否正确
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($token, null, $filePath);
        //第二个参数是保存到空间的图片的名字，默认就好了。
        if ($err !== null) {
            return $err;
        } else {
            return $ret;
        }
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getToken()
    {
        return $this->auth->uploadToken($this->bucket);
        //給上传表单生成上传  token
    }


}
