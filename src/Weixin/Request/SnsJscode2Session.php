<?php

namespace Mayijuntuan\Weixin\Request;

//小程序获取用户access_token
class SnsJscode2Session extends BaseRequest{

    protected $action = '/sns/jscode2session';
    protected $params = [
        'grant_type' => 'authorization_code',
    ];

    public function setAppid( $appid ){
        $this->params['appid'] = $appid;
    }

    public function setSecret( $secret ){
        $this->params['secret'] = $secret;
    }

    public function setJsCode( $js_code ){
        $this->params['js_code'] = $js_code;
    }

    public function setGrantType( $grant_type='authorization_code' ){
        $this->params['grant_type'] = $grant_type;
    }

}
