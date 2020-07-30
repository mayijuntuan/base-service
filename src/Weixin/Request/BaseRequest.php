<?php

namespace Mayijuntuan\Weixin\Request;


class BaseRequest{

    protected $action = '';
    protected $method = 'get';
    protected $format = 'json';
    protected $params = [];
    protected $needAccessToken = false;
    protected $access_token = '';
    protected $needComponentAccessToken = false;
    protected $component_access_token = '';


    public function getAction(){
        return $this->action;
    }

    public function getMethod(){
        return $this->method;
    }

    public function getFormat(){
        return $this->format;
    }

    public function getParams(){
        return $this->params;
    }

    public function getNeedAccessToken(){
        return $this->needAccessToken;
    }

    public function setAccessToken( $access_token ){
        return $this->access_token = $access_token;
    }

    public function getAccessToken(){
        return $this->access_token;
    }

    public function getNeedComponentAccessToken(){
        return $this->needComponentAccessToken;
    }

    public function setComponentAccessToken( $component_access_token ){
        return $this->component_access_token = $component_access_token;
    }

    public function getComponentAccessToken(){
        return $this->component_access_token;
    }

}
