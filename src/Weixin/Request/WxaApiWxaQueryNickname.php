<?php

namespace Mayijuntuan\Weixin\Request;

//查询改名审核状态
class WxaApiWxaQueryNickname extends BaseRequest{

    protected $action = '/wxa/api_wxa_querynickname';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setAuditId( $audit_id ){
        $this->params['audit_id'] = $audit_id;
    }

}
