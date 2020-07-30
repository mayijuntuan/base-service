<?php

namespace Mayijuntuan\Weixin;

use Mayijuntuan\Weixin\Msg\WxBizMsgCrypt;
use Exception;


class Client{

    private $api_url = 'https://api.weixin.qq.com';
    private $component_appid = null;
    private $component_secret = null;
    private $component_token = null;
    private $component_aeskey = null;

    private $appid = null;
    private $secret = null;
    private $token = null;
    private $aeskey = null;


    public function setComponentAppid( $component_appid ){
        $this->component_appid = $component_appid;
    }

    public function setComponentSecret( $component_secret ){
        $this->component_secret = $component_secret;
    }

    public function setComponentToken($component_token){
        $this->component_token = $component_token;
    }

    public function setComponentAeskey($component_aeskey){
        $this->component_aeskey = $component_aeskey;
    }

    public function setAppid($appid){
        $this->appid = $appid;
    }

    public function setSecret($secret){
        $this->secret = $secret;
    }

    public function setToken($token){
        $this->token = $token;
    }

    public function setAeskey($aeskey){
        $this->aeskey = $aeskey;
    }


    //公众号获取授权url
    public function getOauth2Url( $redirect_uri, $scope, $state='' ){

        $auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $redirect_uri = urlencode($redirect_uri);
        $response_type = 'code';

        return $auth_url . '?appid=' . $this->appid . '&redirect_uri=' . $redirect_uri . '&response_type=' . $response_type . '&scope=' . $scope . '&state=' . $state . '#wechat_redirect';

    }

    //代公众号获取授权url
    public function getComponentOauth2Url( $redirect_uri, $scope, $state='' ){

        $auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $redirect_uri = urlencode($redirect_uri);
        $response_type = 'code';

        return $auth_url . '?appid=' . $this->appid . '&redirect_uri=' . $redirect_uri . '&response_type=' . $response_type . '&scope=' . $scope . '&state=' . $state . '&component_appid=' . $this->component_appid . '#wechat_redirect';

    }

    //获取app授权url
    public function getAppAuthUrl( $redirect_uri, $pre_auth_code, $auth_type='', $biz_appid='' ){

        $auth_url = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage';
        $redirect_uri = urlencode($redirect_uri);

        return $auth_url . '?component_appid=' . $this->component_appid . '&pre_auth_code=' . $pre_auth_code . '&redirect_uri=' . $redirect_uri . '&auth_type=' . $auth_type . '&biz_appid=' . $biz_appid;

    }


    //解密用户信息
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
        if( is_null($data) ) {
            throw new Exception('数据格式错误'.$result );
        }
        if( $data->watermark->appid != $this->appid ) {
            throw new Exception('数据格式错误' );
        }

        return $data;

    }


    //消息解密
    public function decryptxml(){
/*
        if( empty($_GET['encrypt_type']) ){
            throw new Exception('encrypt_type不能为空' );
        }
        $encrypt_type = $_GET['encrypt_type'];
*/
        if( empty($_GET['msg_signature']) ){
            throw new Exception('msg_signature不能为空' );
        }
        $msg_signature = $_GET['msg_signature'];

        if( empty($_GET['timestamp']) ){
            throw new Exception('timestamp不能为空' );
        }
        $timestamp = $_GET['timestamp'];

        if( empty($_GET['nonce']) ){
            throw new Exception('nonce不能为空' );
        }
        $nonce = $_GET['nonce'];

        $postData = file_get_contents('php://input');
        if( empty($postData) ){
            throw new Exception('请求数据不能为空' );
        }

        $pc = new WxBizMsgCrypt( $this->component_token, $this->component_aeskey, $this->component_appid );
        $msg = '';
        $errCode = $pc->decryptMsg( $msg_signature, $timestamp, $nonce, $postData, $msg );
        if( $errCode != 0 ){
            throw new Exception('数据解密失败' . $errCode );
        }

        $res = simplexml_load_string( $msg, 'SimpleXMLElement', LIBXML_NOCDATA );
        return json_decode( json_encode($res) );

    }

    //消息加密
    public function encryptxml( $data ){

        $xml = '';
        $xml .= '<xml>';
        foreach( $data as $key=>$value ){
            $xml .= '<'. $key .'><![CDATA['. $value .']]></'. $key .'>';
        }//end foreach
        $xml .= '</xml>';

        $timestamp = time();
        $nonce = md5( date('YmdHis') . rand() );

        $encryptMsg = '';

        $pc = new WXBizMsgCrypt( $this->component_token, $this->component_aeskey, $this->component_appid );
        $errCode = $pc->encryptMsg( $xml, $timestamp, $nonce, $encryptMsg );
        if( $errCode != 0 ){
            throw new Exception('数据加密失败' . $errCode );
        }

        return $encryptMsg;

    }


    //请求接口
    public function request( $request ){

        $action = $request->getAction();
        $method = $request->getMethod();
        $params = $request->getParams();
        $format = $request->getFormat();
        $needAccessToken = $request->getNeedAccessToken();
        $needComponentAccessToken = $request->getNeedComponentAccessToken();

        $url = $this->api_url . $action;
        $ch = curl_init();
        switch($method){
            case 'get':
                if( $needAccessToken ){
                    $params['access_token'] = $request->getAccessToken();
                }
                if( $needComponentAccessToken ){
                    $params['component_access_token'] = $request->getComponentAccessToken();
                }
                if( !empty($params) ){
                    $url .= '?' . http_build_query($params);
                }
                break;
            case 'post':
                if( $needAccessToken ){
                    $url .= '?access_token=' . $request->getAccessToken();
                }
                if( $needComponentAccessToken ){
                    $url .= '?component_access_token=' . $request->getComponentAccessToken();
                }
                $postData = json_encode( $params, JSON_UNESCAPED_UNICODE );
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                break;
        }//end switch
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $content = curl_exec($ch);
        curl_close($ch);

        switch( $format ){
            case 'json':
                    $data = json_decode($content);
                    if( !empty($data->errcode) )
                        throw new Exception('Weixin接口'. $action .'返回错误:' . $data->errcode . ':' . $data->errmsg );

                    return $data;
                break;
            default:
                    return $content;
                break;
        }//end switch

    }

}
