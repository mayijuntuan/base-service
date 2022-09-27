<?php

namespace Mayijuntuan\Weixin\Request;

//设置小程序服务状态
class WxaSetVisitStatus extends BaseRequest{

    protected $action = '/wxa/change_visitstatus';

    public function setAction( $action ){
        $this->data['action'] = $action;
    }

}
