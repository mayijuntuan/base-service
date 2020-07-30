<?php

namespace Mayijuntuan\Weixin\Request;

//获取已设置的所有类目
class WxopenGetCategory extends BaseRequest{
    protected $action = '/wxopen/getcategory';
    protected $needAccessToken = true;
}
