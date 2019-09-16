<?php
namespace Mayijuntuan\Sms;

use Mayijuntuan\Sms\ZsdService;


final class Client
{

    private $client;
    private static $staticClient;

    public function __construct( $storageConfig )
    {
        $driver = $storageConfig['driver'];
        $config = $storageConfig[$driver];

        switch($driver){
            case 'zsd':
                $this->client = new ZsdService($config);
                break;
        }//end switch

    }

    //发送短信
    public function send( $code, $mobile, $content ){
        return $this->client->send( $code, $mobile, $content );
    }

    //获取短信状态
    public function sendStatus( $msgid ){
        return $this->client->sendStatus( $msgid );
    }

    //获取余额
    public function balance(){
        return $this->client->balance();
    }


    private static function getClient(){

        if( !is_null(self::$staticClient) )
            return self::$staticClient;

        $storageConfig = config('mayijuntuan.sms');
        $driver = $storageConfig['driver'];
        $config = $storageConfig[$driver];
        switch($driver){
            case 'zsd':
                self::$staticClient = new ZsdService($config);
                break;
        }//end switch

        return self::$staticClient;

    }

    public static function staticSend( $code, $mobile, $content ){
        return self::getClient()->send( $code, $mobile, $content );
    }

    public static function staticSendStatus( $msgid ){
        return self::getClient()->sendStatus( $msgid );
    }

    public static function staticBalance(){
        return self::getClient()->balance();
    }

}
