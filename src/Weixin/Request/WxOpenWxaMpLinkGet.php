<?php

namespace Mayijuntuan\Weixin\Request;

//获取公众号关联的小程序
class WxOpenWxaMpLinkGet extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/wxamplinkget';
    protected $method = 'post';

}
