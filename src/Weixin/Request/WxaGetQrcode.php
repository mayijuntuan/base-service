<?php

namespace Mayijuntuan\Weixin\Request;

//获取体验版二维码
class WxaGetQrcode extends BaseRequest{

    protected $action = '/wxa/get_qrcode';
    protected $format = '';

}
