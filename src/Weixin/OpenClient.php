<?php

namespace Mayijuntuan\Weixin;

use Mayijuntuan\Weixin\Open\WxBizMsgCrypt;

use Exception;


class OpenClient{

    private $api_url = 'https://api.weixin.qq.com';
    private $appid = '';
    private $secret = '';
    private $token = '';
    private $aeskey = '';

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

    //获取app授权url
    public function getAppAuthUrl( $redirect_uri, $pre_auth_code, $auth_type='' ){
        $appid = $this->appid;
        $redirect_uri = urlencode($redirect_uri);
        $auth_url = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage';
        return $auth_url . '?component_appid=' . $appid . '&redirect_uri=' . $redirect_uri . '&pre_auth_code=' . $pre_auth_code . '&auth_type=' . $auth_type;
    }


    //解密
    public function decryptxml(){

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

        $pc = new WxBizMsgCrypt( $this->token, $this->aeskey, $this->appid );
        $msg = '';
        $errCode = $pc->decryptMsg( $msg_signature, $timestamp, $nonce, $postData, $msg );
        if( $errCode != 0 ){
            throw new Exception('数据解密失败' . $errCode );
        }

        $res = simplexml_load_string( $msg, 'SimpleXMLElement', LIBXML_NOCDATA );
        return json_decode( json_encode($res) );

    }

    //加密
    public function encryptxml( $array ){

        $xml = '';
        $xml .= '<xml>';
        foreach( $array as $key=>$value )
            $xml .= '<'. $key .'><![CDATA['. $value .']]></'. $key .'>';
        $xml .= '</xml>';

        $timestamp = time();
        $nonce = md5( data('YmdHis') . rand() );

        $encryptMsg = '';

        $pc = new WXBizMsgCrypt( $this->token, $this->aeskey, $this->appid );
        $errCode = $pc->encryptMsg( $xml, $timestamp, $nonce, $encryptMsg );
        if( $errCode != 0 ){
            throw new Exception('数据加密失败' . $errCode );
        }

        return $encryptMsg;

    }


    //发送消息
    public function MessageCustomSend( $touser, $msgtype, $text, $access_token ){
        $action = '/cgi-bin/message/custom/send';
        $params = [
            'touser' => $touser,
            'msgtype' => $msgtype,
            'text' => $text,
            'access_token' => $access_token,
        ];
        $res = $this->api( $action, $params );
        return $res->pre_auth_code;
    }


    //读取pre_auth_code
    public function ComponentApiCreatePreauthcode( $component_access_token ){
        $action = '/cgi-bin/component/api_create_preauthcode';
        $params = [
            'component_access_token' => $component_access_token,
        ];
        $res = $this->api( $action, $params );
        return $res->pre_auth_code;
    }

    //使用授权码换取授权信息
    public function ComponentApiQueryAuth( $authorization_code, $component_access_token ){
        $action = '/cgi-bin/component/api_query_auth';
        $params = [
            'authorization_code' => $authorization_code,
            'component_access_token' => $component_access_token,
        ];
        $res = $this->api( $action, $params );
        return $res->authorization_info;
    }

    //获取授权方的帐号基本信息
    public function ComponentApiGetAuthorizerInfo( $authorizer_appid, $component_access_token ){
        $action = '/cgi-bin/component/api_get_authorizer_info';
        $params = [
            'authorizer_appid' => $authorizer_appid,
            'component_access_token' => $component_access_token,
        ];
        $res = $this->api( $action, $params );
        return $res->authorizer_info;
    }

    //获取开放平台access_token
    public function ComponentApiComponentToken( $component_verify_ticket ){
        $action = '/cgi-bin/component/api_component_token';
        $params = [
            'component_appsecret' => $this->secret,
            'component_verify_ticket' => $component_verify_ticket,
        ];
        $res = $this->api( $action, $params );
        return $res->component_access_token;
    }

    private function api( $action, $params=[] ){

        $url = $this->api_url . $action;

        $params['component_appid'] = $this->appid;

        if( !empty($params['component_access_token']) ){
            $url .= '?component_access_token=' . $params['component_access_token'];
            unset($params['component_access_token']);
        }
        $postData = json_encode( $params, JSON_UNESCAPED_UNICODE );


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
