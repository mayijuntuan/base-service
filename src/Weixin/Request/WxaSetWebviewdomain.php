<?php

namespace Mayijuntuan\Weixin\Request;

//设置业务域名
class WxaSetWebviewdomain extends BaseRequest{

    protected $action = '/wxa/setwebviewdomain';
    protected $method = 'post';

    public function setAction( $action ){
        $this->data['action'] = $action;
    }

    public function setWebviewdomain( $webviewdomain ){
        $this->data['webviewdomain'] = $webviewdomain;
    }

}
