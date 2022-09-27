<?php

namespace Mayijuntuan\Weixin\Request;

//修改类目资质信息
class WxOpenModifyCategory extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/modifycategory';
    protected $method = 'post';
    protected $data = [
        'certicates' => [],
    ];

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
