<?php

namespace Mayijuntuan\Weixin\Request;

//设置业务域名
class WxaSetWebviewdomain extends BaseRequest{

    protected $action = '/wxa/setwebviewdomain';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setAction( $action ){
        $this->params['action'] = $action;
    }

    public function setWebviewdomain( $webviewdomain ){
        $this->params['webviewdomain'] = $webviewdomain;
    }

}
