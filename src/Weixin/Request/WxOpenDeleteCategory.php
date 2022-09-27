<?php

namespace Mayijuntuan\Weixin\Request;

//删除类目
class WxOpenDeleteCategory extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/deletecategory';
    protected $method = 'post';

    public function setFirst( $first ){
        $this->data['first'] = $first;
    }

    public function setSecond( $second ){
        $this->data['second'] = $second;
    }

}
