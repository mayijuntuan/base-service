<?php

namespace Mayijuntuan\Weixin\Request;

//查询指定发布审核单的审核状态
class WxaGetAuditStatus extends BaseRequest{

    protected $action = '/wxa/get_auditstatus';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setAuditid( $auditid ){
        $this->params['auditid'] = $auditid;
    }

}
