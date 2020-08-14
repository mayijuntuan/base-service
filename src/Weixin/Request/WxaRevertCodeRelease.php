<?php

namespace Mayijuntuan\Weixin\Request;

//版本回退
class WxaRevertCodeRelease extends BaseRequest{

    protected $action = '/wxa/revertcoderelease';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
