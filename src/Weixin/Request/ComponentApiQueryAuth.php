<?php

namespace Mayijuntuan\Weixin\Request;

//使用授权码换取授权信息
class ComponentApiQueryAuth extends BaseRequest{

    protected $action = '/cgi-bin/component/api_query_auth';
    protected $method = 'post';
    protected $needComponentAccessToken = true;

    public function setComponentAppid( $component_appid ){
        $this->params['component_appid'] = $component_appid;
    }

    public function setAuthorizationCode( $authorization_code ){
        $this->params['authorization_code'] = $authorization_code;
    }

}
