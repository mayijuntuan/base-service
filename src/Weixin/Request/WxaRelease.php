<?php

namespace Mayijuntuan\Weixin\Request;

//发布已通过审核的小程序
class WxaRelease extends BaseRequest{

    protected $action = '/wxa/release';
    protected $method = 'post';

}
