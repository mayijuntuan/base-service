<?php
namespace Mayijuntuan\Captcha;

use Mayijuntuan\Captcha\RecaptchaService;


final class Client
{

    private $client = null;

    public function __construct( $driver, $config )
    {

        switch($driver){
            case 'recaptcha':
                $this->client = new RecaptchaService($config);
                break;
            default:
                throw new \Exception('Driver ' . $driver . ' does not support' );
                break;
        }//end switch

    }

    //验证
    public function verify( $verify_code ){
        return $this->client->verify( $verify_code );
    }

}
