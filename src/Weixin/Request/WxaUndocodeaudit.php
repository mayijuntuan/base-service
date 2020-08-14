<?php

namespace Mayijuntuan\Weixin\Request;

//小程序审核撤回
class WxaUndocodeaudit extends BaseRequest{

    protected $action = '/wxa/undocodeaudit';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
