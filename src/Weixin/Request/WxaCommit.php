<?php

namespace Mayijuntuan\Weixin\Request;

//上传小程序代码
class WxaCommit extends BaseRequest{

    protected $action = '/wxa/commit';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setTemplateId( $template_id ){
        $this->params['template_id'] = $template_id;
    }

    public function setExtJson( $ext_json ){
        $this->params['ext_json'] = $ext_json;
    }

    public function setUserVersion( $user_version ){
        $this->params['user_version'] = $user_version;
    }

    public function setUserDesc( $user_desc ){
        $this->params['user_desc'] = $user_desc;
    }

}
