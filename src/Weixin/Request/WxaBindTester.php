<?php

namespace Mayijuntuan\Weixin\Request;

//绑定微信用户为体验者
class WxaBindTester extends BaseRequest{

    protected $action = '/wxa/bind_tester';
    protected $method = 'post';

    public function setWechatid( $wechatid ){
        $this->data['wechatid'] = $wechatid;
    }

}
