<?php

namespace Mayijuntuan\Weixin\Request;

//获取可以用来设置的公众号列表
class WxaGetWxaMpLinkForShow extends BaseRequest{

    protected $action = '/wxa/getwxamplinkforshow';
    protected $needAccessToken = true;

    public function setPage( $page ){
        $this->params['page'] = $page;
    }

    public function setNum( $num ){
        $this->params['num'] = $num;
    }

}
