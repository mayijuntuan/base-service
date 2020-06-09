<?php

namespace Mayijuntuan\Storage;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;


class QiniuService{

    private $config;
    private $client = null;

    public function __construct( $config ){
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

    //上传
    public function upload( $key, $filePath, $bucket=null ){

        if( is_null($bucket) )
            $bucket = $this->config['bucket'];

        $token = $this->getClient()->uploadToken($bucket);

        $content = file_get_contents($filePath);

        $uploadManager = new UploadManager();
        list( $ret, $err) = $uploadManager->put( $token, $key, $content );
        if( $err === null )
            return $ret;

        return false;

    }

    //列表
    public function getList( $prefix, $bucket=null ){

        if( is_null($bucket) )
            $bucket = $this->config['bucket'];

        $bucketManager = new BucketManager();
        return $bucketManager->listFiles( $bucket, $prefix );

    }

    //获取url
    public function getUrl( $key ){
        if( empty($key) || strpos($key, 'http://') === 0 || strpos($key, 'https://') === 0)
            return $key;
        return $this->config['url'] . $key;
    }

    //删除
    public function delete( $key, $bucket=null ){

        if( is_null($bucket) )
            $bucket = $this->config['bucket'];

        $bucketManager = new BucketManager();
        return $bucketManager->delete( $bucket, $key );

    }

}
