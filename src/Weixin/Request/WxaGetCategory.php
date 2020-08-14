<?php

namespace Mayijuntuan\Weixin\Request;

//获取审核时可填写的类目信息
class WxaGetCategory extends BaseRequest{

    protected $action = '/wxa/get_category';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
