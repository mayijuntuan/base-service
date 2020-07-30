<?php

namespace Mayijuntuan\Weixin\Request;

//设置服务器域名
class WxaModifyDomain extends BaseRequest{

    protected $action = '/wxa/modify_domain';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setAction( $action ){
        $this->params['action'] = $action;
    }

    public function setRequestdomain( $requestdomain ){
        $this->params['requestdomain'] = $requestdomain;
    }

    public function setWsrequestdomain( $wsrequestdomain ){
        $this->params['wsrequestdomain'] = $wsrequestdomain;
    }

    public function setUploaddomain( $uploaddomain ){
        $this->params['uploaddomain'] = $uploaddomain;
    }

    public function setDownloaddomain( $downloaddomain ){
        $this->params['downloaddomain'] = $downloaddomain;
    }

}
