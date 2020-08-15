<?php

namespace Mayijuntuan\Weixin\Request;

//快速创建小程序
class ComponentFastRegisterWeapp extends BaseRequest{

    protected $action = '/cgi-bin/component/fastregisterweapp';
    protected $method = 'post';
    protected $params = [
        'action' => 'create'
    ];

    public function setAction( $action='create' ){
        $this->params['action'] = $action;
    }

    public function setComponentAccessToken( $component_access_token ){
        $this->params['component_access_token'] = $component_access_token;
    }

    public function setName( $name ){
        $this->data['name'] = $name;
    }

    public function setCode( $code ){
        $this->data['code'] = $code;
    }

    public function setCodeType( $code_type ){
        $this->data['code_type'] = $code_type;
    }

    public function setLegalPersonaWechat( $legal_persona_wechat ){
        $this->data['legal_persona_wechat'] = $legal_persona_wechat;
    }

    public function setLegalPersonaName( $legal_persona_name ){
        $this->data['legal_persona_name'] = $legal_persona_name;
    }

    public function setComponentPhone( $component_phone ){
        $this->data['component_phone'] = $component_phone;
    }

}
