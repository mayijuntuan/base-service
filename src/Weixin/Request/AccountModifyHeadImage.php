<?php

namespace Mayijuntuan\Weixin\Request;

//修改头像
class AccountModifyHeadImage extends BaseRequest{

    protected $action = '/cgi-bin/account/modifyheadimage';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setHeadImgMediaId( $head_img_media_id ){
        $this->data['head_img_media_id'] = $head_img_media_id;
    }

    public function setX1( $x1 ){
        $this->data['x1'] = $x1;
    }

    public function setY1( $y1 ){
        $this->data['y1'] = $y1;
    }

    public function setX2( $x2 ){
        $this->data['x2'] = $x2;
    }

    public function setY2( $y2 ){
        $this->data['y2'] = $y2;
    }

}
