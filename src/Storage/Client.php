<?php
namespace Mayijuntuan;

use Mayijuntuan\Storage\S3Service;
use Mayijuntuan\Storage\QiniuService;


final class Client
{

    private $client;
    private static $staticClient;

    public function __construct( $storageConfig )
    {
        $driver = $storageConfig['driver'];
        $config = $storageConfig[$driver];

        switch($driver){
            case 's3':
                $this->client = new S3Service($config);
                break;
            case 'qiniu':
                $this->client = new QiniuService($config);
                break;
        }//end switch

    }

    //上传文件
    public function upload( $key, $filePath, $bucket=null ){
        return $this->client->upload( $key, $filePath, $bucket );
    }

    //获取文件url
    public function getUrl( $key ){
        return $this->client->getUrl( $key );
    }

    private static function getClient(){

        if( !is_null(self::$staticClient) )
            return self::$staticClient;

        $storageConfig = config('mayijuntuan.storage');
        $driver = $storageConfig['driver'];
        $config = $storageConfig[$driver];
        switch($driver){
            case 's3':
                self::$staticClient = new S3Service($config);
                break;
            case 'qiniu':
                self::$staticClient = new QiniuService($config);
                break;
        }//end switch

        return self::$staticClient;

    }

    //上传文件
    public static function staticUpload( $key, $filePath ){
        return self::getClient()->upload( $key, $filePath );
    }

    //获取文件url
    public static function staticGetUrl( $key ){
        return self::getClient()->getUrl( $key );
    }

}
