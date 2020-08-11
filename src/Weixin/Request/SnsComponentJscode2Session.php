<?php

namespace Mayijuntuan\Weixin\Request;

//代小程序获取用户access_token
class SnsComponentJscode2Session extends BaseRequest{

    protected $action = '/sns/component/jscode2session';
    protected $needComponentAccessToken = true;
    protected $params = [
        'grant_type' => 'authorization_code',
    ];

    public function setAppid( $appid ){
        $this->params['appid'] = $appid;
    }

    public function setJsCode( $js_code ){
        $this->params['js_code'] = $js_code;
    }

    public function setGrantType( $grant_type='authorization_code' ){
        $this->params['grant_type'] = $grant_type;
    }

    public function setComponentAppid( $component_appid ){
        $this->params['component_appid'] = $component_appid;
    }

}
