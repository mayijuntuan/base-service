<?php

namespace Mayijuntuan\Weixin\Request;

//添加附近地点(未完成)
class WxaAddNearbyPoi extends BaseRequest{

    protected $action = '/wxa/addnearbypoi';
    protected $data = [
        'is_comm_nearby' => 1,
    ];

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setIsCommNearby( $is_comm_nearby=1 ){
        $this->data['is_comm_nearby'] = $is_comm_nearby;
    }


}
