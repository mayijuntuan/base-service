<?php

namespace Mayijuntuan\Weixin\Request;

//查询指定发布审核单的审核状态
class WxaGetAuditStatus extends BaseRequest{

    protected $action = '/wxa/get_auditstatus';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setAuditid( $auditid ){
        $this->data['auditid'] = $auditid;
    }

}
