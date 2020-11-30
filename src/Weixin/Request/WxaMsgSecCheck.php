<?php

namespace Mayijuntuan\Weixin\Request;

//文本安全内容检测
class WxaMsgSecCheck extends BaseRequest{

    protected $action = '/wxa/msg_sec_check';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setContent( $content ){
        $this->data['content'] = $content;
    }

}
