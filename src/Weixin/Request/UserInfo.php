<?php

namespace Mayijuntuan\Weixin\Request;

//获取用户信息
class UserInfo extends BaseRequest{

    protected $action = '/cgi-bin/user/info';   //或者/sns/userinfo;
    protected $needAccessToken = true;
    protected $params = [
        'lang' => 'zh_CN',
    ];

    public function setOpenid( $openid ){
        $this->params['openid'] = $openid;
    }

    public function setLang( $lang='zh_CN' ){
        $this->params['lang'] = $lang;
    }

}
