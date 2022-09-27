<?php

namespace Mayijuntuan\Weixin\Request;

//将公众号/小程序绑定到开放平台帐号下
class OpenBind extends BaseRequest{

    protected $action = '/cgi-bin/open/bind';
    protected $method = 'post';

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

    public function setOpenAppid( $open_appid ){
        $this->data['open_appid'] = $open_appid;
    }

}
