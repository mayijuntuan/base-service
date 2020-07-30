<?php

namespace Mayijuntuan\Weixin\Request;

//修改头像
class AccountModifyHeadimage extends BaseRequest{

    protected $action = '/cgi-bin/account/modifyheadimage';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setHeadImgMediaId( $head_img_media_id ){
        $this->params['head_img_media_id'] = $head_img_media_id;
    }

    public function setX1( $x1 ){
        $this->params['x1'] = $x1;
    }

    public function setY1( $y1 ){
        $this->params['y1'] = $y1;
    }

    public function setX2( $x2 ){
        $this->params['x2'] = $x2;
    }

    public function setY2( $y2 ){
        $this->params['y2'] = $y2;
    }

}
