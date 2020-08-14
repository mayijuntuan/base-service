<?php

namespace Mayijuntuan\Weixin\Request;

//微信认证名称检测
class WxverifyCheckWxverifyNickname extends BaseRequest{

    protected $action = '/wxverify/checkwxverifynickname';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setNickName( $nick_name ){
        $this->data['nick_name'] = $nick_name;
    }

}
