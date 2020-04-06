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
        return $this->client->listFiles( $prefix, $bucket );
    }

    //获取文件url
    public function getUrl( $key ){
        return $this->client->getFileUrl( $key );
    }

}
