<?php

namespace Mayijuntuan\Weixin\Request;

//代公众号调用接口调用次数清零
class ClearQuota extends BaseRequest{

    protected $action = '/cgi-bin/clear_quota';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

}
