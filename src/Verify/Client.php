<?php
namespace Mayijuntuan\Verify;

use Mayijuntuan\Verify\GeetestService;

use Exception;


final class Client
{

    private $client = null;

    public function __construct( $driver, $config )
    {

        switch($driver){
            case 'geetest':
                $this->client = new GeetestService($config);
                break;
            default:
                throw new Exception('Driver ' . $driver . ' does not support' );
                break;
        }//end switch

    }

    //获取流水标识
    public function preverify(){
        return $this->client->preverify();
    }

    //验证
    public function verify( $challenge, $validate, $seccode ){
        return $this->client->verify($challenge, $validate, $seccode);
    }

}
