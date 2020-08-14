<?php

namespace Mayijuntuan\Weixin\Request;

//代公众号获取刷新用户access_token
class SnsOauth2ComponentRefreshToken extends BaseRequest{

    protected $action = '/sns/oauth2/component/refresh_token';
    protected $params = [
        'grant_type' => 'refresh_token',
    ];

    public function setAppid( $appid ){
        $this->params['appid'] = $appid;
    }

    public function setRefreshToken( $refresh_token ){
        $this->params['refresh_token'] = $refresh_token;
    }

    public function setGrantType( $grant_type='refresh_token' ){
        $this->params['grant_type'] = $grant_type;
    }

    public function setComponentAppid( $component_appid ){
        $this->params['component_appid'] = $component_appid;
    }

    public function setComponentAccessToken( $component_access_token ){
        $this->params['component_access_token'] = $component_access_token;
    }

}
