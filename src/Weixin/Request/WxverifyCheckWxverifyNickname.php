<?php

namespace Mayijuntuan\Weixin\Request;

//微信认证名称检测
class WxverifyCheckWxverifyNickname extends BaseRequest{

    protected $action = '/wxverify/checkwxverifynickname';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setNickName( $nick_name ){
        $this->params['nick_name'] = $nick_name;
    }

}
