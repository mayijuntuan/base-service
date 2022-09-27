<?php

namespace Mayijuntuan\Weixin\Request;

//展示/取消展示附近小程序
class WxaSetNearbyPoiShowStatus extends BaseRequest{

    protected $action = '/wxa/setnearbypoishowstatus';

    public function setPoiId( $poi_id ){
        $this->data['poi_id'] = $poi_id;
    }

    public function setStatus( $status ){
        $this->data['status'] = $status;
    }

}
