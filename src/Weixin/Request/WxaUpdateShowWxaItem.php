<?php

namespace Mayijuntuan\Weixin\Request;

//设置展示的公众号信息
class WxaUpdateShowWxaItem extends BaseRequest{

    protected $action = '/wxa/updateshowwxaitem';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setWxaSubscribeBizFlag( $wxa_subscribe_biz_flag ){
        $this->params['wxa_subscribe_biz_flag'] = $wxa_subscribe_biz_flag;
    }

    public function setAppid( $appid ){
        $this->params['appid'] = $appid;
    }

}
