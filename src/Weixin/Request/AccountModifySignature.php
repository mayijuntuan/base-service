<?php

namespace Mayijuntuan\Weixin\Request;

//修改功能介绍
class AccountModifySignature extends BaseRequest{

    protected $action = '/cgi-bin/account/modifysignature';
    protected $method = 'post';

    public function setSignature( $signature ){
        $this->data['signature'] = $signature;
    }

}
