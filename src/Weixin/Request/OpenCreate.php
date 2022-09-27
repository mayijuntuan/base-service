<?php

namespace Mayijuntuan\Weixin\Request;

//创建开放平台帐号并绑定公众号/小程序
class OpenCreate extends BaseRequest{

    protected $action = '/cgi-bin/open/create';
    protected $method = 'post';

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

}
