<?php

namespace Mayijuntuan\Weixin\Request;

//获取预授权码
class ComponentApiCreatePreAuthCode extends BaseRequest{

    protected $action = '/cgi-bin/component/api_create_preauthcode';
    protected $method = 'post';
    protected $needComponentAccessToken = true;

    public function setComponentAppid( $component_appid ){
        $this->params['component_appid'] = $component_appid;
    }

}
