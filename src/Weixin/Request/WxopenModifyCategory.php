<?php

namespace Mayijuntuan\Weixin\Request;

//修改类目资质信息
class WxopenModifyCategory extends BaseRequest{

    protected $action = '/wxopen/modifycategory';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setFirst( $first ){
        $this->params['first'] = $first;
    }

    public function setSecond( $second ){
        $this->params['second'] = $second;
    }

    public function setCerticates( $certicates ){
        $this->params['certicates'] = $certicates;
    }

}
