<?php

namespace Mayijuntuan\Weixin\Request;

//查询隐私设置
class WxaGetWxaSearchStatus extends BaseRequest{

    protected $action = '/wxa/getwxasearchstatus';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
