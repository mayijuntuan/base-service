<?php

namespace Mayijuntuan\Weixin\Request;

//查询隐私设置
class WxaGetWxaSearchStatus extends BaseRequest{
    protected $action = '/wxa/getwxasearchstatus';
    protected $needAccessToken = true;
}
