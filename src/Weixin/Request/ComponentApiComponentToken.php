<?php

namespace Mayijuntuan\Weixin\Request;

//获取令牌
class ComponentApiComponentToken extends BaseRequest{

    protected $action = '/cgi-bin/component/api_component_token';
    protected $method = 'post';

    public function setComponentAppid( $component_appid ){
        $this->data['component_appid'] = $component_appid;
    }

    public function setComponentAppSecret( $component_appsecret ){
        $this->data['component_appsecret'] = $component_appsecret;
    }

    public function setComponentVerifyTicket( $component_verify_ticket ){
        $this->data['component_verify_ticket'] = $component_verify_ticket;
    }

}
