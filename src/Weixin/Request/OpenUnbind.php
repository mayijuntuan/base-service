<?php

namespace Mayijuntuan\Weixin\Request;

//将公众号/小程序从开放平台帐号下解绑
class OpenUnbind extends BaseRequest{

    protected $action = '/cgi-bin/open/unbind';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

    public function setOpenAppid( $open_appid ){
        $this->data['open_appid'] = $open_appid;
    }

}
