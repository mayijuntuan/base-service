<?php

namespace Mayijuntuan\Weixin\Request;

//拉取所有已授权的帐号信息
class ComponentApiGetAuthorizerList extends BaseRequest{

    protected $action = '/cgi-bin/component/api_get_authorizer_list';
    protected $method = 'post';

    public function setComponentAccessToken( $component_access_token ){
        $this->params['component_access_token'] = $component_access_token;
    }

    public function setComponentAppid( $component_appid ){
        $this->data['component_appid'] = $component_appid;
    }

    public function setOffset( $offset ){
        $this->data['offset'] = $offset;
    }

    public function setCount( $count ){
        $this->data['count'] = $count;
    }

}
