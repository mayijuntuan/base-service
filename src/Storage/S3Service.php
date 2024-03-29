<?php

namespace Mayijuntuan\Storage;

use Aws\S3\S3Client;


class S3Service{

    private $config;
    private $client = null;

    public function __construct( $config ){
        $this->config = $config;
    }

    private function getClient(){
        if( is_null($this->client) ){
            $params = [
                'version' => 'latest',
                'region' => $this->config['region'],
                'credentials' => [
                    'key' => $this->config['access_key'],
                    'secret' => $this->config['secret_key']
                ],
            ];
            $this->client = new S3Client($params);
        }
        return $this->client;
    }

    //上传
    public function upload( $key, $filePath ){

        $bucket = $this->config['bucket'];

        $params = [
            'ACL' => 'public-read',
            'ContentType' => 'image/jpg',
            'Bucket' => $bucket,
            'Key' => $key,
            'Body' => file_get_contents($filePath)
        ];
        return $this->getClient()->putObject($params);

    }

    //列表
    public function getList( $options=[] ){

        $bucket = $this->config['bucket'];

        $params = [
            'ACL' => 'public-read',
            'ContentType' => 'image/jpg',
            'Bucket' => $bucket
        ];
        return $this->getClient()->listObjects( $params );

    }

    //获取base url
    public function getBaseUrl(){
        return $this->config['url'];
    }

    //删除
    public function delete( $key ){

        $bucket = $this->config['bucket'];

        $params = [
            'ACL' => 'public-read',
            'ContentType' => 'image/jpg',
            'Bucket' => $bucket,
            'Key' => $key
        ];
        return $this->getClient()->deleteObject($params);

    }

}