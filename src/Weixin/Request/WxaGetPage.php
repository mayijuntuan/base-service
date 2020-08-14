<?php

namespace Mayijuntuan\Weixin\Request;

//获取已上传的代码的页面列表
class WxaGetPage extends BaseRequest{

    protected $action = '/wxa/get_page';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

}
