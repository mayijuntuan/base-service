<?php

namespace Mayijuntuan\Weixin\Request;

//获取预授权码
class ComponentApiCreatePreAuthCode extends BaseRequest{

    protected $action = '/cgi-bin/component/api_create_preauthcode';
    protected $method = 'post';

    public function setComponentAccessToken( $component_access_token ){
        $this->params['component_access_token'] = $component_access_token;
    }

    public function setComponentAppid( $component_appid ){
        $this->data['component_appid'] = $component_appid;
    }

}
