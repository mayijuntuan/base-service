<?php

namespace Mayijuntuan\Weixin\Request;

//解除绑定体验者
class WxaUnbindTester extends BaseRequest{

    protected $action = '/wxa/unbind_tester';
    protected $method = 'post';

    public function setWechatid( $wechatid ){
        $this->data['wechatid'] = $wechatid;
    }

    public function setUserstr( $userstr ){
        $this->data['userstr'] = $userstr;
    }

}
