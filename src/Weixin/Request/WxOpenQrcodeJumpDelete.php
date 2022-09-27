<?php

namespace Mayijuntuan\Weixin\Request;

//删除已设置的二维码规则
class WxOpenQrcodeJumpDelete extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/qrcodejumpdelete';
    protected $method = 'post';

    public function setPrefix( $prefix ){
        $this->setData( 'prefix', $prefix );
    }

}
