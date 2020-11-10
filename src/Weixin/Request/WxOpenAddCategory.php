<?php

namespace Mayijuntuan\Weixin\Request;

//添加类目
class WxOpenAddCategory extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/addcategory';
    protected $method = 'post';
    protected $data = [
        'certicates' => [],
    ];

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setFirst( $first ){
        $this->data['first'] = $first;
    }

    public function setSecond( $second ){
        $this->data['second'] = $second;
    }

    public function setCerticates( $certicates ){
        $this->data['certicates'] = $certicates;
    }

}
