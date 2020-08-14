<?php

namespace Mayijuntuan\Weixin\Request;

//设置名称
class WxaSetNickname extends BaseRequest{

    protected $action = '/wxa/setnickname';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setNickName( $nick_name ){
        $this->data['nick_name'] = $nick_name;
    }

    public function setIdCard( $id_card ){
        $this->data['id_card'] = $id_card;
    }

    public function setLicense( $license ){
        $this->data['license'] = $license;
    }

    public function setNamingOtherStuff1( $naming_other_stuff ){
        $this->data['naming_other_stuff_1'] = $naming_other_stuff;
    }

    public function setNamingOtherStuff2( $naming_other_stuff ){
        $this->data['naming_other_stuff_2'] = $naming_other_stuff;
    }

    public function setNamingOtherStuff3( $naming_other_stuff ){
        $this->data['naming_other_stuff_3'] = $naming_other_stuff;
    }

    public function setNamingOtherStuff4( $naming_other_stuff ){
        $this->data['naming_other_stuff_4'] = $naming_other_stuff;
    }

    public function setNamingOtherStuff5( $naming_other_stuff ){
        $this->data['naming_other_stuff_5'] = $naming_other_stuff;
    }

}
