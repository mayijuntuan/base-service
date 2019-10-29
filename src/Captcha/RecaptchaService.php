<?php

namespace Mayijuntuan\Captcha;

use Exception;


class RecaptchaService{

    private $api_url = 'https://www.google.com/recaptcha/api/siteverify';
    private $config;

    public function __construct( $config )
    {
        $this->config = $config;
    }

    /**
     * 验证
     *
     * @param $code
     * @param $mobile
     * @param $content
     * @return string
     */
    public function verify( $verify_code ){

        $params = array(
            'response' => $verify_code,
        );
        $res = $this->api($params);
        if( !empty($res->success) && $res->success == true )
            return true;

        return false;

    }//end function send


    private function api( $params=[] ){

        $params['secret'] = $this->config['secret'];

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $this->api_url );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params) );

        $result = curl_exec($ch);
        $errorno = curl_errno($ch);
        $error = curl_error($ch);
        $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close($ch);

        if( $errorno )
            throw new Exception('请求返回接口错误'.$errorno.$error );
        if( $code != 200 )
            throw new Exception('curl返回状态码错误'.$code );

        $res = json_decode($result);
        if( !is_object($res) )
            throw new Exception('curl返回内容格式错误'.$result );

        return $res;

    }

}