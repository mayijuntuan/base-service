<?php

namespace Mayijuntuan\Weixin\Request;

//设置授权方选项信息
class ComponentApiSetAuthorizerOption extends BaseRequest{

    protected $action = '/cgi-bin/component/api_set_authorizer_option';
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

    public function setOptionName( $option_name ){
        $this->data['option_name'] = $option_name;
    }

    public function setOptionValue( $option_value ){
        $this->data['option_value'] = $option_value;
    }

}
