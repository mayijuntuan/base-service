<?php

namespace Mayijuntuan\Verify;

use GeetestLib;


class GeetestService{

    private $config;
    private $client = null;

    public function __construct($config)
    {
        $this->config = $config;
    }

    private function getClient(){
        if( is_null($this->client) ){
            $captcha_id = $this->config['captcha_id'];
            $private_key = $this->config['private_key'];
            $this->client = new GeetestLib( $captcha_id, $private_key );
        }
        return $this->client;
    }

    /**
     * 获取流水标识
     *
     * @return string
     */
    public function preverify(){
        return $this->getClient()->get_response_str();
    }

    /**
     * 验证
     *
     * @param $challenge
     * @param $validate
     * @return boolean
     */
    public function verify($challenge, $validate, $seccode){

        $data = array(
            "user_id" => "test", # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
        );
        $status = $this->getClient()->pre_process($data, 1);
        if( $status != 1 )
            return false;

        $result = $this->getClient()->success_validate($challenge, $validate, $seccode, $data);
        if( !$result )
            return false;

        return true;

    }

}