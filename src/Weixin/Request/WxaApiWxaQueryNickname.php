<?php

namespace Mayijuntuan\Weixin\Request;

//查询改名审核状态
class WxaApiWxaQueryNickname extends BaseRequest{

    protected $action = '/wxa/api_wxa_querynickname';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setAuditId( $audit_id ){
        $this->data['audit_id'] = $audit_id;
    }

}
