<?php

namespace Mayijuntuan\Weixin\Request;

//获取体验版二维码
class WxaGetQrcode extends BaseRequest{

    protected $action = '/wxa/get_qrcode';
    protected $format = '';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
