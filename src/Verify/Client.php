<?php
namespace Mayijuntuan\Verify;

use Mayijuntuan\Verify\GeetestService;


final class Client
{

    private static $staticClient;

    public function __construct( $smsConfig )
    {
        self::setConfig( $smsConfig );
    }

    public static function setConfig( $verifyConfig ){

        $driver = $verifyConfig['driver'];
        $config = $verifyConfig[$driver];
        switch($driver){
            case 'geetest':
                self::$staticClient = new GeetestService($config);
                break;
        }//end switch

        return self::$staticClient;

    }

    private static function getClient(){

        if( !is_null(self::$staticClient) )
            return self::$staticClient;

        $verifyConfig = config('mayijuntuan.verify');
        return self::setConfig( $verifyConfig );

    }

    //获取流水标识
    public function preverify(){
        return self::getClient()->preverify();
    }

    //获取流水标识
    public static function staticPreverify(){
        return self::getClient()->preverify();
    }

    //验证
    public function verify( $challenge, $validate, $seccode ){
        return self::getClient()->verify($challenge, $validate, $seccode);
    }

    //验证
    public static function staticVerify( $challenge, $validate, $seccode ){
        return self::getClient()->verify($challenge, $validate, $seccode);
    }

}
