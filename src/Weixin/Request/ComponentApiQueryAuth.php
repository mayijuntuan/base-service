<?php

namespace Mayijuntuan\Weixin\Request;

//使用授权码获取授权信息
class ComponentApiQueryAuth extends BaseRequest{

    protected $action = '/cgi-bin/component/api_query_auth';
    protected $method = 'post';

    public function setComponentAccessToken( $component_access_token ){
        $this->params['component_access_token'] = $component_access_token;
    }

    public function setComponentAppid( $component_appid ){
        $this->data['component_appid'] = $component_appid;
    }

    public function setAuthorizationCode( $authorization_code ){
        $this->data['authorization_code'] = $authorization_code;
    }

}
