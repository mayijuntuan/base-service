<?php

namespace Mayijuntuan\Storage;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;


class QiniuService{

    private $config;
    private $client = null;

    public function __construct($config)
    {
        $this->config = $config;
    }

    private function getClient(){
        if( is_null($this->client) ){
            $access_key = $this->config['access_key'];
            $secret_key = $this->config['secret_key'];
            $this->client = new Auth( $access_key, $secret_key );
        }
        return $this->client;
    }

    //上传文件
    public function uploadFile( $key, $filePath, $bucket=null ){

        if( is_null($bucket) )
            $bucket = $this->config['bucket'];

        $token = $this->getClient()->uploadToken($bucket);

        $content = file_get_contents($filePath);

        $uploadManager = new UploadManager();
        list( $ret, $err) = $uploadManager->put( $token, $key, $content );
        if( $err === null )
            return $key;

        return false;

    }

    //文件列表
    public function listFiles( $prefix, $bucket ){

        if( is_null($bucket) )
            $bucket = $this->config['bucket'];

        $bucketManager = new BucketManager();
        $list = $bucketManager->listFiles( $bucket, $prefix );
        return $list;

    }

    //获取文件url
    public function getFileUrl($filename){
        if( empty($filename) || strpos($filename, 'http://') === 0 || strpos($filename, 'https://') === 0)
            return $filename;
        return $this->config['url'] . $filename;
    }

}
