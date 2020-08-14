<?php

namespace Mayijuntuan\Weixin\Request;

//第三方平台对其所有 API 调用次数清零（只与第三方平台相关，与公众号无关，接口如 api_component_token）
class ComponentClearQuota extends BaseRequest{

    protected $action = '/cgi-bin/component/clear_quota';
    protected $method = 'post';

    public function setComponentAccessToken( $component_access_token ){
        $this->params['component_access_token'] = $component_access_token;
    }

    public function setComponentAppid( $component_appid ){
        $this->data['component_appid'] = $component_appid;
    }

}
