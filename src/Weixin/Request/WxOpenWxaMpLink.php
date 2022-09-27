<?php

namespace Mayijuntuan\Weixin\Request;

//关联小程序
class WxOpenWxaMpLink extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/wxamplink';
    protected $method = 'post';

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

    public function setNotifyUsers( $notify_users=1 ){
        $this->data['notify_users'] = $notify_users;
    }

    public function setShowProfile( $show_profile=1 ){
        $this->data['show_profile'] = $show_profile;
    }

}
