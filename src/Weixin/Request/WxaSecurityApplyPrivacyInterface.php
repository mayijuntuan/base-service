<?php

namespace Mayijuntuan\Weixin\Request;

//获取地理位置接口列表
class WxaSecurityApplyPrivacyInterface extends BaseRequest{

    protected $action = '/wxa/security/apply_privacy_interface';
    protected $method = 'post';

    public function setApiName( $api_name ){
        $this->data['api_name'] = $api_name;
    }

    public function setContent( $content ){
        $this->data['content'] = $content;
    }

    public function setUrlList( $url_list ){
        $this->data['url_list'] = $url_list;
    }

    public function setPicList( $pic_list ){
        $this->data['pic_list'] = $pic_list;
    }

    public function setVideoList( $video_list ){
        $this->data['video_list'] = $video_list;
    }

}
