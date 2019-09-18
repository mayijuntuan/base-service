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

    //上传文件
    public function upload( $key, $filePath, $bucket=null ){

        if( is_null($bucket) )
            $bucket = $this->config['bucket'];

        $content = file_get_contents($filePath);

        return $this->getClient()->putObject( $bucket, $key, $content );

    }

    //获取文件url
    public function getUrl($filename){
        if( empty($filename) || strpos($filename, 'http://') === 0 || strpos($filename, 'https://') === 0)
            return $filename;
        return $this->config['url'] . $filename;
    }

}