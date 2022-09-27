<?php

namespace Mayijuntuan\Weixin\Request;

//查询小程序版本信息
class WxaGetVersionInfo extends BaseRequest{

    protected $action = '/wxa/getversioninfo';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
