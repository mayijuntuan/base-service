<?php

namespace Mayijuntuan\Weixin\Request;

//删除附近地点
class WxaDelNearbyPoi extends BaseRequest{

    protected $action = '/wxa/addnearbypoi';

    public function setPoiId( $poi_id ){
        $this->data['poi_id'] = $poi_id;
    }

}
