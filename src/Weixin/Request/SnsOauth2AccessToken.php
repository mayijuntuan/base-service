<?php

namespace Mayijuntuan\Weixin\Request;

//公众号获取用户access_token
class SnsOauth2AccessToken extends BaseRequest{

    protected $action = '/sns/oauth2/access_token';
    protected $params = [
        'grant_type' => 'authorization_code',
    ];

    public function setAppid( $appid ){
        $this->params['appid'] = $appid;
    }

    public function setSecret( $secret ){
        $this->params['secret'] = $secret;
    }

    public function setCode( $code ){
        $this->params['code'] = $code;
    }

    public function setGrantType( $grant_type='authorization_code' ){
        $this->params['grant_type'] = $grant_type;
    }

}
