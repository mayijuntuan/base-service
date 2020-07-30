<?php

namespace Mayijuntuan\Weixin\Request;

//获取可以设置的所有类目
class WxopenGetAllCategories extends BaseRequest{
    protected $action = '/wxopen/getallcategories';
    protected $needAccessToken = true;
}
