<?php

namespace Mayijuntuan\Weixin\Request;

//获取开放平台access_token
class ComponentApiComponentToken extends BaseRequest{

    protected $action = '/cgi-bin/component/api_component_token';
    protected $method = 'post';

    public function setComponentAppid( $component_appid ){
        $this->params['component_appid'] = $component_appid;
    }

    public function setComponentAppSecret( $component_appsecret ){
        $this->params['component_appsecret'] = $component_appsecret;
    }

    public function setComponentVerifyTicket( $component_verify_ticket ){
        $this->params['component_verify_ticket'] = $component_verify_ticket;
    }


}
