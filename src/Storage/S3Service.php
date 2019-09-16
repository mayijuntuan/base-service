<?php

namespace Mayijuntuan\Storage;

use Aws\S3\S3Client;


class S3Service{

    private $config;
    private $client = null;

    public function __construct($config)
    {
        $this->config = $config;
    }

    private function getClient(){
        if( is_null($this->client) ){
            $this->client = new S3Client([
                'version' => 'latest',
                'region' => $this->config['region'],
                'credentials' => [
                    'key' => $this->config['access_key'],
                    'secret' => $this->config['secret_key']
                ],
            ]);
        }
        return $this->client;
    }

    //上传文件
    public function upload( $key, $filePath, $bucket=null ){
        return $this->getClient()->putObject([
            'ACL' => 'public-read',
            'ContentType' => 'image/jpg',
            'Bucket' => is_null($bucket) ? $this->config['bucket'] : $bucket,
            'Key' => $key,
            'Body' => file_get_contents($filePath)
        ]);
    }

    //获取文件url
    public function getUrl($filename){
        if( empty($filename) || strpos($filename, 'http://') === 0 || strpos($filename, 'https://') === 0)
            return $filename;
        return $this->config['url'] . $filename;
    }

}