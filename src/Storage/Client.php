<?php
namespace Mayijuntuan\Storage;

use Mayijuntuan\Storage\OssService;
use Mayijuntuan\Storage\QiniuService;
use Mayijuntuan\Storage\S3Service;

use Exception;


final class Client
{

    private $client = null;

    public function __construct( $driver, $config )
    {

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

    //上传文件
    public function upload( $key, $filePath, $bucket=null ){
        return $this->client->uploadFile( $key, $filePath, $bucket );
    }

    //文件列表
    public function listFiles( $prefix='', $bucket=null ){

        $objectListInfo = $this->client->listFiles( $prefix, $bucket );

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

        $bucketName = $objectListInfo->getBucketName();
        $prefix = $objectListInfo->getPrefix();
        $marker = $objectListInfo->getMarker();
        $nextMarker = $objectListInfo->getNextMarker();
        $maxKeys = $objectListInfo->getMaxKeys();
        $delimiter = $objectListInfo->getDelimiter();
        $isTruncated = $objectListInfo->getIsTruncated();

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

    //获取文件url
    public function getUrl( $key ){
        return $this->client->getFileUrl( $key );
    }

}
