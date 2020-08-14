<?php

namespace Mayijuntuan\Weixin\Request;

//获取可以用来设置的公众号列表
class WxaGetWxaMpLinkForShow extends BaseRequest{

    protected $action = '/wxa/getwxamplinkforshow';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setPage( $page ){
        $this->params['page'] = $page;
    }

    public function setNum( $num ){
        $this->params['num'] = $num;
    }

}
