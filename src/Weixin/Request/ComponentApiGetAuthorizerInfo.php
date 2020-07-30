<?php

namespace Mayijuntuan\Weixin\Request;

//获取授权方的帐号基本信息
class ComponentApiGetAuthorizerInfo extends BaseRequest{

    protected $action = '/cgi-bin/component/api_get_authorizer_info';
    protected $method = 'post';
    protected $needComponentAccessToken = true;

    public function setComponentAppid( $component_appid ){
        $this->params['component_appid'] = $component_appid;
    }

    public function setAuthorizerAppid( $authorizer_appid ){
        $this->params['authorizer_appid'] = $authorizer_appid;
    }

}
