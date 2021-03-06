<?php

namespace Mayijuntuan\Weixin\Request;

//获取/刷新接口调用令牌
class ComponentApiAuthorizerToken extends BaseRequest{

    protected $action = '/cgi-bin/component/api_authorizer_token';
    protected $method = 'post';

    public function setComponentAccessToken( $component_access_token ){
        $this->params['component_access_token'] = $component_access_token;
    }

    public function setComponentAppid( $component_appid ){
        $this->data['component_appid'] = $component_appid;
    }

    public function setAuthorizerAppid( $authorizer_appid ){
        $this->data['authorizer_appid'] = $authorizer_appid;
    }

    public function setAuthorizerRefreshToken( $authorizer_refresh_token ){
        $this->data['authorizer_refresh_token'] = $authorizer_refresh_token;
    }

}
