<?php

namespace Mayijuntuan\Weixin\Request;

//代公众号调用接口调用次数清零
class ClearQuota extends BaseRequest{

    protected $action = '/cgi-bin/clear_quota';
    protected $method = 'post';

    public function setAppid( $appid ){
        $this->data['appid'] = $appid;
    }

}
