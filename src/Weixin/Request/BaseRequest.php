<?php

namespace Mayijuntuan\Weixin\Request;


class BaseRequest{

    protected $action = '';
    protected $method = 'get';
    protected $format = 'json';
    protected $postFormat = 'json';
    protected $params = [];
    protected $data = [];

    public function getAction(){
        return $this->action;
    }

    public function getMethod(){
        return $this->method;
    }

    public function getFormat(){
        return $this->format;
    }

    public function getPostFormat(){
        return $this->postFormat;
    }

    public function getParams(){
        return $this->params;
    }

    public function setParams( $key, $value ){
        $this->params[$key] = $value;
    }

    public function getData(){
        return $this->data;
    }

    public function setData( $key, $value ){
        $this->data[$key] = $value;
    }

}
