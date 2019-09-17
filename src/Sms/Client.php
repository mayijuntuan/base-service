<?php
namespace Mayijuntuan\Sms;

use Mayijuntuan\Sms\ZsdService;
use Mayijuntuan\Sms\AlibabaService;


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
            case 'alibaba':
                $this->client = new AlibabaService($config);
                break;
        }//end switch

    }

    //发送短信
    public function send( $code, $mobile, $content ){
        return $this->client->send( $code, $mobile, $content );
    }

    //按模板发送短信
    public function sendTemplate( $code, $mobile, $templateCode, $templateParams ){
        return $this->client->sendTemplate( $code, $mobile, $templateCode, $templateParams );
    }

    //获取短信状态
    public function sendStatus( $msgid ){
        return $this->client->sendStatus( $msgid );
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
            case 'alibaba':
                self::$staticClient = new AlibabaService($config);
                break;
        }//end switch

        return self::$staticClient;

    }

    //发送短信
    public static function staticSend( $code, $mobile, $content ){
        return self::getClient()->send( $code, $mobile, $content );
    }

    //按模板发送短信
    public static function staticSendTemplate( $code, $mobile, $templateCode, $templateParams ){
        return self::getClient()->sendTemplate( $code, $mobile, $templateCode, $templateParams );
    }

    //获取短信状态
    public static function staticSendStatus( $msgid ){
        return self::getClient()->sendStatus( $msgid );
    }

}
