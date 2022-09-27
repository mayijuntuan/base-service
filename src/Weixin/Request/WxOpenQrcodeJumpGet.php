<?php

namespace Mayijuntuan\Weixin\Request;

//获取已设置的二维码规则
class WxOpenQrcodeJumpGet extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/qrcodejumpget';
    protected $method = 'post';

}
