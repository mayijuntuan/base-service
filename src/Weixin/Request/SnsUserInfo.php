<?php

namespace Mayijuntuan\Weixin\Request;

//获取用户基本信息
class SnsUserInfo extends BaseRequest{

    protected $action = '/sns/userinfo';
    protected $params = [
        'lang' => 'zh_CN',
    ];

    public function setOpenid( $openid ){
        $this->params['openid'] = $openid;
    }

    public function setLang( $lang='zh_CN' ){
        $this->params['lang'] = $lang;
    }

}
