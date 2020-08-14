<?php

namespace Mayijuntuan\Weixin\Request;

//获取授权方的帐号基本信息
class ComponentApiGetAuthorizerInfo extends BaseRequest{

    protected $action = '/cgi-bin/component/api_get_authorizer_info';
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

}
