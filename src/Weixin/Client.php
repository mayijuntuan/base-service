<?php

namespace Mayijuntuan\Weixin;

use Exception;


class Client{

    private $api_url = 'https://api.weixin.qq.com';
    private $appid = '';
    private $secret = '';

    public function setAppid($appid){
        $this->appid = $appid;
    }

    public function setSecret($secret){
        $this->secret = $secret;
    }


    public function jscode2session( $code ){

        $action = '/sns/jscode2session';
        $params = [
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];
        return $this->api( $action, $params );

    }

    public function getToken( $code ){

        $action = '/sns/oauth2/access_token';
        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
        ];
        return $this->api( $action, $params );

    }

    public function getUserinfo( $access_token, $openid ){

        $action = '/sns/userinfo';
        $params = [
            'access_token' => $access_token,
            'openid' => $openid,
            'lang' => 'zh_CN',
        ];
        return $this->api( $action, $params );

    }

    public function decryptData( $sessionKey, $encryptedData, $iv ){

        if (strlen($sessionKey) != 24) {
            throw new Exception('sessionKey长度错误' );
        }
        $aesKey = base64_decode($sessionKey);

        if (strlen($iv) != 24) {
            throw new Exception('iv长度错误' );
        }
        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $result = openssl_decrypt( $aesCipher, 'AES-128-CBC', $aesKey, 1, $aesIV );

        $data = json_decode( $result );
        if( $data  == NULL ) {
            throw new Exception('数据格式错误'.$result );
        }
        if( $data->watermark->appid != $this->appid ) {
            throw new Exception('数据格式错误' );
        }

        return $data;

    }

    private function api( $action, $params=[] ){

        $params['appid'] = $this->appid;
        $params['secret'] = $this->secret;

        $postData = http_build_query($params);

        $url = $this->api_url . $action;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($data);
        if( !empty($res->errcode) )
            throw new Exception('Weixin接口返回错误:' . $res->errcode . ':' . $res->errmsg );

        return $res;

    }

}
