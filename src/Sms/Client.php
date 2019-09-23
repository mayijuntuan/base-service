<?php
namespace Mayijuntuan\Sms;

use Mayijuntuan\Sms\ZsdService;
use Mayijuntuan\Sms\AlibabaService;

use Exception;


final class Client
{

    private $client = null;

    public function __construct( $driver, $config )
    {

        switch($driver){
            case 'zsd':
                $this->client = new ZsdService($config);
                break;
            case 'alibaba':
                $this->client = new AlibabaService($config);
                break;
            default:
                throw new Exception('Driver ' . $driver . ' does not support' );
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

}
