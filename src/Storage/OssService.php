<?php

namespace Mayijuntuan\Storage;

use OSS\OssClient;


class OssService{

    private $config;
    private $client = null;

    public function __construct($config)
    {
        $this->config = $config;
    }

    private function getClient(){
        if( is_null($this->client) ){
            $accessKeyId = $this->config['accesskey_id'];
            $accessKeySecret = $this->config['accesskey_secret'];
            $endpoint = $this->config['endpoint'];
            $this->client = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        }
        return $this->client;
    }

    //上传
    public function upload( $key, $filePath, $bucket=null ){

        if( is_null($bucket) )
            $bucket = $this->config['bucket'];

        $content = file_get_contents($filePath);

        return $this->getClient()->putObject( $bucket, $key, $content );

    }

    //列表
    public function getList( $prefix='', $bucket=null ){

        if( is_null($bucket) )
            $bucket = $this->config['bucket'];

        $options = [
            'prefix' => $prefix,
        ];
        return $this->getClient()->listObjects( $bucket, $options );

    }

    //获取url
    public function getUrl( $key ){
        if( empty($key) || strpos($key, 'http://') === 0 || strpos($key, 'https://') === 0)
            return $key;
        return $this->config['url'] . $key;
    }

    //删除
    public function delete( $key, $bucket=null  ){

        if( is_null($bucket) )
            $bucket = $this->config['bucket'];

        return $this->getClient()->deleteObject( $bucket, $key );

    }

}