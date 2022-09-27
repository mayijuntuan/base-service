<?php

namespace Mayijuntuan\Weixin\Request;

//解除已关联的小程序
class WxOpenWxaMpUnlink extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/wxampunlink';
    protected $method = 'post';

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

}
