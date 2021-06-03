<?php

namespace Mayijuntuan\Weixin\Request;

//添加附近地点
class WxaAddNearbyPoi extends BaseRequest{

    protected $action = '/wxa/addnearbypoi';
    protected $data = [
        'is_comm_nearby' => 1,
    ];

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setPoiId( $poi_id ){
        $this->data['poi_id'] = $poi_id;
    }

    public function setIsCommNearby( $is_comm_nearby=1 ){
        $this->data['is_comm_nearby'] = $is_comm_nearby;
    }

    public function setPicList( $pic_list ){
        $this->data['pic_list'] = $pic_list;
    }

    public function setServiceInfos( $service_infos ){
        $this->data['service_infos'] = $service_infos;
    }

    public function setKfInfo( $kf_info ){
        $this->data['kf_info'] = $kf_info;
    }

    public function setStoreName( $store_name ){
        $this->data['store_name'] = $store_name;
    }

    public function setHour( $hour ){
        $this->data['hour'] = $hour;
    }

    public function setAddress( $address ){
        $this->data['address'] = $address;
    }

    public function setCompanyName( $company_name ){
        $this->data['company_name'] = $company_name;
    }

    public function setContractPhone( $contract_phone ){
        $this->data['contract_phone'] = $contract_phone;
    }

    public function setCredential( $credential ){
        $this->data['credential'] = $credential;
    }

    public function setQualificationList( $qualification_list ){
        $this->data['qualification_list'] = $qualification_list;
    }

    public function setMapPoiId( $map_poi_id ){
        $this->data['map_poi_id'] = $map_poi_id;
    }

}
