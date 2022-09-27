<?php

namespace Mayijuntuan\Weixin\Request;

//发布已设置的二维码规则
class WxOpenQrcodeJumpPublish extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/qrcodejumppublish';
    protected $method = 'post';

    public function setPrefix( $prefix ){
        $this->setData( 'prefix', $prefix );
    }

}
