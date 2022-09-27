<?php

namespace Mayijuntuan\Weixin\Request;

//查看附近地点列表
class WxaGetNearbyPoiList extends BaseRequest{

    protected $action = '/wxa/getnearbypoilist';
    protected $params = [
        'page' => 1,
        'page_rows' => 100,
    ];

    public function setPage( $page=1 ){
        $this->params['page'] = $page;
    }

    public function setPageRows( $page_rows=100 ){
        $this->params['page_rows'] = $page_rows;
    }

}
