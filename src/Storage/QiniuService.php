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
    public function upload( $key, $filePath ){

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
    public function getList( $options=[] ){

        $bucket = $this->config['bucket'];

        $prefix = isset($options['prefix']) ? $options['prefix'] : null;
        $marker = isset($options['marker']) ? $options['marker'] : null;
        $limit = isset($options['limit']) ? $options['limit'] : 1000;
        $delimiter = isset($options['delimiter']) ? $options['delimiter'] : null;

        $bucketManager = new BucketManager();
        return $bucketManager->listFiles( $bucket, $prefix, $marker, $limit, $delimiter );

    }

    //获取base url
    public function getBaseUrl(){
        return $this->config['url'];
    }

    //删除
    public function delete( $key ){

        $bucket = $this->config['bucket'];

        $bucketManager = new BucketManager();
        return $bucketManager->delete( $bucket, $key );

    }

}
