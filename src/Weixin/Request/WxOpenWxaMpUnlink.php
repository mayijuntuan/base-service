<?php

namespace Mayijuntuan\Weixin\Request;

//解除已关联的小程序
class WxOpenWxaMpUnlink extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/wxampunlink';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

}
