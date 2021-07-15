<?php

namespace Mayijuntuan\Weixin\Request;

//获取小程序 URL Link
class WxaGenerateUrllink extends BaseRequest{

    protected $action = '/wxa/generate_urllink';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setPath( $path ){
        $this->data['path'] = $path;
    }

    public function setQuery( $query ){
        $this->data['query'] = $query;
    }

    public function setIsExpire( $is_expire ){
        $this->data['is_expire'] = $is_expire;
    }

    public function setExpireType( $expire_type ){
        $this->data['expire_type'] = $expire_type;
    }

    public function setExpireTime( $expire_time ){
        $this->data['expire_time'] = $expire_time;
    }

    public function setExpireInterval( $expire_interval ){
        $this->data['expire_interval'] = $expire_interval;
    }

}
