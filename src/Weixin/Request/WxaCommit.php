<?php

namespace Mayijuntuan\Weixin\Request;

//上传小程序代码
class WxaCommit extends BaseRequest{

    protected $action = '/wxa/commit';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setTemplateId( $template_id ){
        $this->data['template_id'] = $template_id;
    }

    public function setExtJson( $ext_json ){
        $this->data['ext_json'] = $ext_json;
    }

    public function setUserVersion( $user_version ){
        $this->data['user_version'] = $user_version;
    }

    public function setUserDesc( $user_desc ){
        $this->data['user_desc'] = $user_desc;
    }

}
