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
    private $component_access_token = null;
    private $appid = null;
    private $secret = null;
    private $token = null;
    private $aeskey = null;
    private $access_token = null;


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

    public function setComponentAccessToken( $component_access_token ){
        $this->component_access_token = $component_access_token;
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

    public function setAccessToken($access_token){
        $this->access_token = $access_token;
    }


    //获取授权url
    public function getOauth2Url( $redirect_uri, $scope, $state='' ){

        $auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $redirect_uri = urlencode($redirect_uri);
        $response_type = 'code';

        return $auth_url . '?appid=' . $this->appid . '&redirect_uri=' . $redirect_uri . '&response_type=' . $response_type . '&scope=' . $scope . '&state=' . $state . '#wechat_redirect';

    }

    //获取用户access_token
    public function SnsOauth2AccessToken( $code ){

        $action = '/sns/oauth2/access_token';
        $params = [
            'appid' => $this->appid,
            'secret' => $this->secret,
            'grant_type' => 'authorization_code',
            'code' => $code,
        ];
        return $this->api( $action, $params );

    }

    //获取用户access_token
    public function SnsJscode2session( $code ){

        $action = '/sns/jscode2session';
        $params = [
            'appid' => $this->appid,
            'secret' => $this->secret,
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];
        return $this->api( $action, $params );

    }

    //获取用户信息
    public function getUserInfo( $access_token, $openid ){

        $action = '/cgi-bin/user/info';
        $params = [
            'access_token' => $access_token,
            'openid' => $openid,
            'lang' => 'zh_CN',
        ];
        return $this->api( $action, $params );

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

    //获取应用access_token
    public function getToken( $code ){

        $action = '/cgi-bin/token';
        $params = [
            'grant_type' => 'client_credential',
            'appid' => $this->appid,
            'secret' => $this->secret,
        ];
        return $this->api( $action, $params );

    }

    //发送消息
    public function MessageCustomSend( $access_token, $touser, $msgtype, $typeData, $customservice=null ){

        $action = '/cgi-bin/message/custom/send?access_token=' . $access_token;
        $params = [
            'touser' => $touser,
            'msgtype' => $msgtype,
        ];
        $params[$msgtype] = $typeData;
        if( !is_null($customservice) ){
            $params['customservice'] = [
                'kf_account' => $customservice,
            ];
        }
        return $this->api( $action, $params, 'post' );

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


    //获取授权url
    public function getComponentOauth2Url( $redirect_uri, $scope, $state='' ){

        $auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $redirect_uri = urlencode($redirect_uri);
        $response_type = 'code';

        return $auth_url . '?appid=' . $this->appid . '&redirect_uri=' . $redirect_uri . '&response_type=' . $response_type . '&scope=' . $scope . '&state=' . $state . '&component_appid=' . $this->component_appid . '#wechat_redirect';

    }

    //获取access_token
    public function SnsOauth2ComponentAccessToken( $code ){

        $action = '/sns/oauth2/component/access_token';
        $params = [
            'appid' => $this->appid,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        return $this->api( $action, $params );

    }

    //获取access_token
    public function SnsComponentJscode2session( $code ){

        $action = '/sns/component/jscode2session';
        $params = [
            'appid' => $this->appid,
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];
        return $this->api( $action, $params );

    }


    //获取app授权url
    public function getAppAuthUrl( $redirect_uri, $pre_auth_code, $auth_type='', $biz_appid='' ){

        $auth_url = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage';
        $redirect_uri = urlencode($redirect_uri);

        return $auth_url . '?component_appid=' . $this->component_appid . '&pre_auth_code=' . $pre_auth_code . '&redirect_uri=' . $redirect_uri . '&auth_type=' . $auth_type . '&biz_appid=' . $biz_appid;

    }

    //读取pre_auth_code
    public function ComponentApiCreatePreauthcode( $component_access_token ){
        $action = '/cgi-bin/component/api_create_preauthcode?component_access_token=' . $component_access_token;
        $params = [
            'component_appid' => $this->component_appid,
        ];
        return $this->api( $action, $params, 'post' );
    }

    //使用授权码换取授权信息
    public function ComponentApiQueryAuth( $component_access_token, $authorization_code ){
        $action = '/cgi-bin/component/api_query_auth?component_access_token=' . $component_access_token;
        $params = [
            'component_appid' => $this->component_appid,
            'authorization_code' => $authorization_code,
        ];
        return $this->api( $action, $params, 'post' );
    }

    //获取授权方的帐号基本信息
    public function ComponentApiGetAuthorizerInfo( $component_access_token, $authorizer_appid ){
        $action = '/cgi-bin/component/api_get_authorizer_info?component_access_token=' . $component_access_token;
        $params = [
            'component_appid' => $this->component_appid,
            'authorizer_appid' => $authorizer_appid,
        ];
        return $this->api( $action, $params, 'post' );
    }

    //获取开放平台access_token
    public function ComponentApiComponentToken( $component_verify_ticket ){
        $action = '/cgi-bin/component/api_component_token';
        $params = [
            'component_appid' => $this->component_appid,
            'component_appsecret' => $this->component_secret,
            'component_verify_ticket' => $component_verify_ticket,
        ];
        return $this->api( $action, $params, 'post' );
    }


    //请求接口
    private function api( $action, $params=[], $method='get' ){

        $url = $this->api_url . $action;

        $ch = curl_init();
        switch($method){
            case 'get':
                    if( !empty($params) ){
                        $url .= '?' . http_build_query($params);
                    }
                break;
            case 'post':
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
        $data = json_decode($content);
        if( !empty($data->errcode) )
            throw new Exception('Weixin接口返回错误:' . $data->errcode . ':' . $data->errmsg );

        return $data;

    }

}
