<?php

namespace Mayijuntuan\Weixin\Request;

//获取公众号/小程序所绑定的开放平台帐号
class OpenGet extends BaseRequest{

    protected $action = '/cgi-bin/open/get';
    protected $method = 'post';

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

}
