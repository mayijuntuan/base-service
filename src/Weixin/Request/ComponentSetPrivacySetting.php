<?php

namespace Mayijuntuan\Weixin\Request;

//设置小程序用户隐私保护指引
class ComponentSetPrivacySetting extends BaseRequest{

    protected $action = '/cgi-bin/component/setprivacysetting';
    protected $method = 'post';

    public function setPrivacyVer( $privacy_ver ){
        $this->data['privacy_ver'] = $privacy_ver;
    }

    public function setSettingList( $setting_list ){
        $this->data['setting_list'] = $setting_list;
    }

    public function setOwnerSetting( $owner_setting ){
        $this->data['owner_setting'] = $owner_setting;
    }

    public function setSdkPrivacyInfoList( $sdk_privacy_info_list ){
        $this->data['sdk_privacy_info_list'] = $sdk_privacy_info_list;
    }

}
