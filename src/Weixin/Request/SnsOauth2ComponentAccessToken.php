<?php

namespace Mayijuntuan\Weixin\Request;

//代公众号获取用户access_token
class SnsOauth2ComponentAccessToken extends BaseRequest{

    protected $action = '/sns/oauth2/component/access_token';
    protected $needComponentAccessToken = true;
    protected $params = [
        'grant_type' => 'authorization_code',
    ];

    public function setAppid( $appid ){
        $this->params['appid'] = $appid;
    }

    public function setCode( $code ){
        $this->params['code'] = $code;
    }

    public function setGrantType( $grant_type='authorization_code' ){
        $this->params['grant_type'] = $grant_type;
    }

    public function setComponentAppid( $component_appid ){
        $this->params['component_appid'] = $component_appid;
    }

}
