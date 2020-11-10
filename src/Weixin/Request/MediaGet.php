<?php

namespace Mayijuntuan\Weixin\Request;

//获取临时素材
class MediaGet extends BaseRequest{

    protected $action = '/cgi-bin/media/get';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setMediaId( $media_id ){
        $this->params['media_id'] = $media_id;
    }

}
