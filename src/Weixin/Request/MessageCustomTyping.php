<?php

namespace Mayijuntuan\Weixin\Request;

//客服输入状态
class MessageCustomTyping extends BaseRequest{

    protected $action = '/cgi-bin/message/custom/typing';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setToUser( $touser ){
        $this->data['touser'] = $touser;
    }

    public function setCommand( $command ){
        $this->data['command'] = $command;
    }

}
