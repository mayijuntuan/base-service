<?php

namespace Mayijuntuan\Weixin\Request;

//设置服务器域名
class WxaModifyDomain extends BaseRequest{

    protected $action = '/wxa/modify_domain';
    protected $method = 'post';

    public function setAction( $action ){
        $this->data['action'] = $action;
    }

    public function setRequestdomain( $requestdomain ){
        $this->data['requestdomain'] = $requestdomain;
    }

    public function setWsrequestdomain( $wsrequestdomain ){
        $this->data['wsrequestdomain'] = $wsrequestdomain;
    }

    public function setUploaddomain( $uploaddomain ){
        $this->data['uploaddomain'] = $uploaddomain;
    }

    public function setDownloaddomain( $downloaddomain ){
        $this->data['downloaddomain'] = $downloaddomain;
    }

}
