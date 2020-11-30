<?php

namespace Mayijuntuan\Weixin\Request;

//图片安全内容检测
class WxaImgSecCheck extends BaseRequest{

    protected $action = '/wxa/img_sec_check';
    protected $method = 'post';
    protected $postFormat = '';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setMedia( $media ){
        $this->data['media'] = $media;
    }

}
