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
    public function upload( $key, $filePath, $bucket=null ){
        return $this->client->upload( $key, $filePath, $bucket );
    }

    //列表
    public function getList( $prefix='', $bucket=null ){

        $objectListInfo = $this->client->getList( $prefix, $bucket );

        $bucketName = $objectListInfo->getBucketName();
        $prefix = $objectListInfo->getPrefix();
        $marker = $objectListInfo->getMarker();
        $nextMarker = $objectListInfo->getNextMarker();
        $maxKeys = $objectListInfo->getMaxKeys();
        $delimiter = $objectListInfo->getDelimiter();
        $isTruncated = $objectListInfo->getIsTruncated();

        $objectList = $objectListInfo->getObjectList();
        $allObjectList = [];
        foreach( $objectList as $objectInfo ){
            $allObjectList[] = [
                'key' => $objectInfo->getKey(),
                'lastModified' => $objectInfo->getLastModified(),
                'eTag' => $objectInfo->getETag(),
                'type' => $objectInfo->getType(),
                'size' => $objectInfo->getSize(),
                'storageClass' => $objectInfo->getStorageClass(),
            ];
        }//end foreach

        $prefixList = $objectListInfo->getPrefixList();
        $allPrefixList = [];
        foreach( $prefixList as $prefixInfo ){
            $allPrefixList[] = [
                'prefix' => $prefixInfo->getPrefix(),
            ];
        }//end foreach

        return [
            'bucketName' => $bucketName,
            'prefix' => $prefix,
            'marker' => $marker,
            'nextMarker' => $nextMarker,
            'maxKeys' => $maxKeys,
            'delimiter' => $delimiter,
            'isTruncated' => $isTruncated,
            'objectList' => $allObjectList,
            'prefixList' => $allPrefixList,
        ];

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
