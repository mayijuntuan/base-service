<?php

namespace Mayijuntuan\Weixin\Request;

//获取小程序用户隐私保护指引
class ComponentGetPrivacySetting extends BaseRequest{

    protected $action = '/cgi-bin/component/getprivacysetting';
    protected $method = 'post';

    public function setPrivacyVer( $privacy_ver ){
        $this->data['privacy_ver'] = $privacy_ver;
    }

}
