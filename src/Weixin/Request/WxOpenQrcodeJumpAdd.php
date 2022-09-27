<?php

namespace Mayijuntuan\Weixin\Request;

//增加或修改二维码规则
class WxOpenQrcodeJumpAdd extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/qrcodejumpadd';
    protected $method = 'post';

    public function setPrefix( $prefix ){
        $this->setData( 'prefix', $prefix );
    }

    public function setPermitSubRule( $permit_sub_rule ){
        $this->setData( 'permit_sub_rule', $permit_sub_rule );
    }

    public function setPath( $path ){
        $this->setData( 'path', $path );
    }

    public function setOpenVersion( $open_version=3 ){
        $this->setData( 'open_version', $open_version );
    }

    public function setDebugUrl( $debug_url=[] ){
        $this->setData( 'debug_url', $debug_url );
    }

    public function setIsEdit( $is_edit=0 ){
        $this->setData( 'is_edit', $is_edit );
    }

}
