<?php

namespace Mayijuntuan\Weixin\Request;

//客服输入状态
class MessageCustomTyping extends BaseRequest{

    protected $action = '/cgi-bin/message/custom/typing';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setToUser( $touser ){
        $this->params['touser'] = $touser;
    }

    public function setCommand( $command ){
        $this->params['command'] = $command;
    }

}
