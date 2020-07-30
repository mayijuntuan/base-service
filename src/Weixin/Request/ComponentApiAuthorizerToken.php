<?php

namespace Mayijuntuan\Weixin\Request;

//获取/刷新接口调用令牌
class ComponentApiAuthorizerToken extends BaseRequest{

    protected $action = '/cgi-bin/component/api_authorizer_token';
    protected $method = 'post';
    protected $needComponentAccessToken = true;

    public function setComponentAppid( $component_appid ){
        $this->params['component_appid'] = $component_appid;
    }

    public function setAuthorizerAppid( $authorizer_appid ){
        $this->params['authorizer_appid'] = $authorizer_appid;
    }

    public function setAuthorizerRefreshToken( $authorizer_refresh_token ){
        $this->params['authorizer_refresh_token'] = $authorizer_refresh_token;
    }

}
