<?php

namespace Mayijuntuan\Weixin\Request;

//获取用户信息
class UserInfo extends BaseRequest{

    protected $action = '/cgi-bin/user/info';
    protected $params = [
        'lang' => 'zh_CN',
    ];

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setOpenid( $openid ){
        $this->params['openid'] = $openid;
    }

    public function setLang( $lang='zh_CN' ){
        $this->params['lang'] = $lang;
    }

}
