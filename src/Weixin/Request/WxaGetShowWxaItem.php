<?php

namespace Mayijuntuan\Weixin\Request;

//获取展示的公众号信息
class WxaGetShowWxaItem extends BaseRequest{

    protected $action = '/wxa/getshowwxaitem';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
