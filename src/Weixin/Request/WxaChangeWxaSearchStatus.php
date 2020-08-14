<?php

namespace Mayijuntuan\Weixin\Request;

//修改隐私设置
class WxaChangeWxaSearchStatus extends BaseRequest{

    protected $action = '/wxa/changewxasearchstatus';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setStatus( $status ){
        $this->data['status'] = $status;
    }

}
