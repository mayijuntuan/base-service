<?php

namespace Mayijuntuan\Weixin\Request;

//获取小程序的基本信息
class AccountGetAccountBaseInfo extends BaseRequest{
    protected $action = '/cgi-bin/account/getaccountbasicinfo';
}
