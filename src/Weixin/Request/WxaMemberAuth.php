<?php

namespace Mayijuntuan\Weixin\Request;

//获取体验者列表
class WxaMemberAuth extends BaseRequest{

    protected $action = '/wxa/memberauth';
    protected $method = 'post';
    protected $data = [
        'action' => 'get_experiencer',
    ];

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setAction( $action='get_experiencer' ){
        $this->data['action'] = $action;
    }

}
