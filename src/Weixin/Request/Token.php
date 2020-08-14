<?php

namespace Mayijuntuan\Weixin\Request;

//获取公众号/小程序access_token
class Token extends BaseRequest{

    protected $action = '/cgi-bin/token';
    protected $method = 'post';
    protected $data = [
        'grant_type' => 'authorization_code',
    ];

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

    public function setSecret( $secret ){
        $this->data['secret'] = $secret;
    }

    public function setGrandType( $grant_type='client_credential' ){
        $this->data['grant_type'] = $grant_type;
    }

}
