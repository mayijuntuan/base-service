<?php

namespace Mayijuntuan\Weixin\Request;

//添加类目
class WxopenAddCategory extends BaseRequest{

    protected $action = '/wxopen/addcategory';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setCategories( $categories ){
        $this->params['categories'] = $categories;
    }

}
