<?php

namespace Mayijuntuan\Weixin\Request;

//添加类目
class WxOpenAddCategory extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/addcategory';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setCategories( $categories ){
        $this->data['categories'] = $categories;
    }

}
