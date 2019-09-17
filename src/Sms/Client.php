<?php
namespace Mayijuntuan\Sms;

use Mayijuntuan\Sms\ZsdService;
use Mayijuntuan\Sms\AlibabaService;


final class Client
{

    private static $staticClient;

    public function __construct( $smsConfig )
    {
        self::setConfig( $smsConfig );
    }

    public static function setConfig( $smsConfig ){

        $driver = $smsConfig['driver'];
        $config = $smsConfig[$driver];
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

    private static function getClient(){

        if( !is_null(self::$staticClient) )
            return self::$staticClient;

        $smsConfig = config('mayijuntuan.sms');
        return self::setConfig( $smsConfig );

    }

    //发送短信
    public function send( $code, $mobile, $content ){
        return self::getClient()->send( $code, $mobile, $content );
    }

    //按模板发送短信
    public function sendTemplate( $code, $mobile, $templateCode, $templateParams ){
        return self::getClient()->sendTemplate( $code, $mobile, $templateCode, $templateParams );
    }

    //获取短信状态
    public function sendStatus( $msgid ){
        return self::getClient()->sendStatus( $msgid );
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
