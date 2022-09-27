<?php

namespace Mayijuntuan\Weixin\Request;

//加急审核申请
class WxaSpeedupAudit extends BaseRequest{

    protected $action = '/wxa/speedupaudit';
    protected $method = 'post';

    public function setAuditid( $auditid ){
        $this->data['auditid'] = $auditid;
    }

}
