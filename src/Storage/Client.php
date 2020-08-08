<?php

namespace Mayijuntuan\Storage;

use Exception;


final class Client{

    private $client = null;

    public function __construct( $driver, $config ){

        switch($driver){
            case 'oss':
                $this->client = new OssService($config);
                break;
            case 'qiniu':
                $this->client = new QiniuService($config);
                break;
            case 's3':
                $this->client = new S3Service($config);
                break;
            default:
                throw new Exception('Driver ' . $driver . ' does not support' );
                break;
        }//end switch

    }

    //bucket列表
    public function listBuckets(){
        return $this->client->listBuckets();
    }

    //创建bucket
    public function createBucket( $bucket ){
        return $this->client->createBucket( $bucket );
    }

    //删除bucket
    public function deleteBucket( $bucket ){
        return $this->client->deleteBucket( $bucket );
    }

    //上传
    public function upload( $key, $filePath ){
        return $this->client->upload( $key, $filePath );
    }

    //列表
    public function getList( $options=[] ){
        return $this->client->getList( $options );
    }

    //获取url
    public function getUrl( $key ){
        return $this->client->getUrl( $key );
    }

    //删除
    public function delete( $key ){
        return $this->client->delete( $key );
    }

}
