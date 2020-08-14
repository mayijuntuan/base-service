<?php

namespace Mayijuntuan\Weixin\Request;

//获取可以设置的所有类目
class WxOpenGetAllCategories extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/getallcategories';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
