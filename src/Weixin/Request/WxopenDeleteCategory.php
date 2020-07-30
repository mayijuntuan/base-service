<?php

namespace Mayijuntuan\Weixin\Request;

//删除类目
class WxopenDeleteCategory extends BaseRequest{

    protected $action = '/wxopen/deletecategory';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setFirst( $first ){
        $this->params['first'] = $first;
    }

    public function setSecond( $second ){
        $this->params['second'] = $second;
    }

}
