<?php

namespace Mayijuntuan\Storage;

use OSS\OssClient;


class OssService{

    private $config;
    private $client = null;

    public function __construct( $config ){
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

    //bucket列表
    public function listBuckets(){
        return $this->getClient()->listBuckets();
    }

    //创建bucket
    public function createBucket( $bucket ){
        return $this->getClient()->createBucket( $bucket, OssClient::OSS_ACL_TYPE_PUBLIC_READ );
    }

    //删除bucket
    public function deleteBucket( $bucket ){
        return $this->getClient()->deleteBucket( $bucket );
    }

    //上传
    public function upload( $key, $filePath ){

        $bucket = $this->config['bucket'];

        $content = file_get_contents($filePath);

        return $this->getClient()->putObject( $bucket, $key, $content );

    }

    //列表
    public function getList( $options=[] ){

        if( isset($options['limit']) ){
            $options['max-keys'] = $options['limit'];
        }

        $bucket = $this->config['bucket'];

        $objectListInfo = $this->getClient()->listObjects( $bucket, $options );

        $bucketName = $objectListInfo->getBucketName();
        $prefix = $objectListInfo->getPrefix();
        $marker = $objectListInfo->getMarker();
        $limit = $objectListInfo->getMaxKeys();
        $delimiter = $objectListInfo->getDelimiter();
        $nextMarker = $objectListInfo->getNextMarker();

        $fileList = [];
        $objectList = $objectListInfo->getObjectList();
        foreach( $objectList as $objectInfo ){
            $name = $objectInfo->getKey();
            $url = $this->config['url'] . $name;
            $fileList[] = [
                'name' => $name,
                'url' => $url,
                'modify' => strtotime($objectInfo->getLastModified()),
                'tag' => $objectInfo->getETag(),
                'size' => $objectInfo->getSize(),
            ];
        }//end foreach

        $folderList = [];
        $prefixList = $objectListInfo->getPrefixList();
        foreach( $prefixList as $prefixInfo ){
            $fullname = $prefixInfo->getPrefix();
            $name = str_replace( $prefix,'', $fullname );
            $name = str_replace( '/','', $name );
            $folderList[] = [
                'name' => $name,
                'fullname' => $fullname,
            ];
        }//end foreach

        return [
            'bucketName' => $bucketName,
            'prefix' => $prefix,
            'marker' => $marker,
            'limit' => $limit,
            'delimiter' => $delimiter,
            'nextMarker' => $nextMarker,
            'fileList' => $fileList,
            'folderList' => $folderList,
        ];

    }

    //获取url
    public function getUrl( $key ){
        if( empty($key) || strpos($key, 'http://') === 0 || strpos($key, 'https://') === 0)
            return $key;
        return $this->config['url'] . $key;
    }

    //删除
    public function delete( $key  ){

        $bucket = $this->config['bucket'];

        return $this->getClient()->deleteObject( $bucket, $key );

    }

}