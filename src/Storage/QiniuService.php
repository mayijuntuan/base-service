<?php

namespace Mayijuntuan\Storage;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;


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
    public function upload( $key, $filePath, $bucket=null ){

        $bucket = is_null($bucket) ? $this->config['bucket'] : $bucket;

        $token = $this->getClient()->uploadToken($bucket);

        $uploadManager = new UploadManager();
        list( $ret, $err) = $uploadManager->put( $token, $key, file_get_contents($filePath) );

        if( $err === null )
            return $key;

        return false;

    }

    //获取文件url
    public function getUrl($filename){
        if( empty($filename) || strpos($filename, 'http://') === 0 || strpos($filename, 'https://') === 0)
            return $filename;
        return $this->config['url'] . $filename;
    }

}