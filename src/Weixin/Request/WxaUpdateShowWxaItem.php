<?php

namespace Mayijuntuan\Weixin\Request;

//设置展示的公众号信息
class WxaUpdateShowWxaItem extends BaseRequest{

    protected $action = '/wxa/updateshowwxaitem';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setWxaSubscribeBizFlag( $wxa_subscribe_biz_flag ){
        $this->data['wxa_subscribe_biz_flag'] = $wxa_subscribe_biz_flag;
    }

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

}
