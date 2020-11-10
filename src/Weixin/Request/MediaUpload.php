<?php

namespace Mayijuntuan\Weixin\Request;

//上传临时素材
class MediaUpload extends BaseRequest{

    protected $action = '/cgi-bin/media/upload';
    protected $method = 'post';
    protected $postFormat = '';
    protected $params = [
        'type' => 'image',
    ];

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setType( $type='image' ){
        $this->params['type'] = $type;
    }

    public function setMedia( $media ){
        $this->data['media'] = $media;
    }

}
