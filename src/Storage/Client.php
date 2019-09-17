<?php
namespace Mayijuntuan\Storage;

use Mayijuntuan\Storage\S3Service;
use Mayijuntuan\Storage\QiniuService;


final class Client
{

    private static $staticClient;

    public function __construct( $storageConfig )
    {
        self::setConfig( $storageConfig );
    }

    public static function setConfig( $storageConfig ){

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

    private static function getClient(){

        if( !is_null(self::$staticClient) )
            return self::$staticClient;

        $storageConfig = config('mayijuntuan.storage');
        return self::setConfig( $storageConfig );

    }

    //上传文件
    public function upload( $key, $filePath, $bucket=null ){
        return self::getClient()->upload( $key, $filePath, $bucket );
    }

    //获取文件url
    public function getUrl( $key ){
        return self::getClient()->getUrl( $key );
    }

    //上传文件
    public static function staticUpload( $key, $filePath, $bucket=null ){
        return self::getClient()->upload( $key, $filePath, $bucket );
    }

    //获取文件url
    public static function staticGetUrl( $key ){
        return self::getClient()->getUrl( $key );
    }

}
