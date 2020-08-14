<?php

namespace Mayijuntuan\Weixin\Request;

//获取已设置的所有类目
class WxOpenGetCategory extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/getcategory';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
