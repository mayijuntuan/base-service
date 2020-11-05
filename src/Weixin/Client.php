<?php

namespace Mayijuntuan\Weixin;

use Exception;
use Mayijuntuan\Weixin\Msg\WxBizMsgCrypt;
use Mayijuntuan\Weixin\Request\ComponentApiAuthorizerToken;
use Mayijuntuan\Weixin\Request\ComponentApiComponentToken;
use Mayijuntuan\Weixin\Request\ComponentApiCreatePreAuthCode;
use Mayijuntuan\Weixin\Request\ComponentApiGetAuthorizerInfo;
use Mayijuntuan\Weixin\Request\ComponentApiGetAuthorizerList;
use Mayijuntuan\Weixin\Request\ComponentApiGetAuthorizerOption;
use Mayijuntuan\Weixin\Request\ComponentApiQueryAuth;
use Mayijuntuan\Weixin\Request\ComponentApiSetAuthorizerOption;
use Mayijuntuan\Weixin\Request\OpenBind;
use Mayijuntuan\Weixin\Request\OpenCreate;
use Mayijuntuan\Weixin\Request\OpenGet;
use Mayijuntuan\Weixin\Request\OpenUnbind;
use Mayijuntuan\Weixin\Request\SnsComponentJscode2Session;
use Mayijuntuan\Weixin\Request\SnsJscode2Session;
use Mayijuntuan\Weixin\Request\SnsOauth2AccessToken;
use Mayijuntuan\Weixin\Request\SnsOauth2ComponentAccessToken;
use Mayijuntuan\Weixin\Request\SnsOauth2ComponentRefreshToken;
use Mayijuntuan\Weixin\Request\SnsUserInfo;
use Mayijuntuan\Weixin\Request\Token;
use Mayijuntuan\Weixin\Request\WxaCommit;
use Mayijuntuan\Weixin\Request\WxaCommitAudit;
use Mayijuntuan\Weixin\Request\WxaGetAuditStatus;
use Mayijuntuan\Weixin\Request\WxaGetLatestAuditStatus;
use Mayijuntuan\Weixin\Request\WxaGetPage;
use Mayijuntuan\Weixin\Request\WxaGetQrcode;
use Mayijuntuan\Weixin\Request\WxaRelease;
use Mayijuntuan\Weixin\Request\WxaUndocodeaudit;


class Client{

    private $api_url = 'https://api.weixin.qq.com';
    private $appid = null;
    private $secret = null;
    private $token = null;
    private $aeskey = null;

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


    //公众号获取用户授权链接
    public function getOauth2Url( $redirect_uri, $scope, $state='' ){

        $auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $redirect_uri = urlencode($redirect_uri);
        $response_type = 'code';

        return $auth_url . '?appid=' . $this->appid . '&redirect_uri=' . $redirect_uri . '&response_type=' . $response_type . '&scope=' . $scope . '&state=' . $state . '#wechat_redirect';

    }

    //第三方代公众号获取用户授权链接
    public function getComponentOauth2Url( $appid, $redirect_uri, $scope, $state='' ){

        $auth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $redirect_uri = urlencode($redirect_uri);
        $response_type = 'code';

        return $auth_url . '?appid=' . $appid . '&redirect_uri=' . $redirect_uri . '&response_type=' . $response_type . '&scope=' . $scope . '&state=' . $state . '&component_appid=' . $this->appid . '#wechat_redirect';

    }

    //第三方获取应用授权链接
    public function getAppAuthUrl( $redirect_uri, $pre_auth_code, $auth_type='', $biz_appid='' ){

        $auth_url = 'https://mp.weixin.qq.com/cgi-bin/componentloginpage';
        $redirect_uri = urlencode($redirect_uri);

        return $auth_url . '?component_appid=' . $this->appid . '&pre_auth_code=' . $pre_auth_code . '&redirect_uri=' . $redirect_uri . '&auth_type=' . $auth_type . '&biz_appid=' . $biz_appid;

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

        return $data;

    }

    //消息解密
    public function decryptxml( $msg_signature, $timestamp, $nonce, $postData ){

        $pc = new WxBizMsgCrypt( $this->token, $this->aeskey, $this->appid );
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

        $pc = new WXBizMsgCrypt( $this->token, $this->aeskey, $this->appid );
        $errCode = $pc->encryptMsg( $xml, $timestamp, $nonce, $encryptMsg );
        if( $errCode != 0 ){
            throw new Exception('数据加密失败' . $errCode );
        }

        return $encryptMsg;

    }


    //获取令牌
    public function getToken(){
        $request = new Token();
        $request->setAppid( $this->appid );
        $request->setSecret( $this->secret );
        return $this->request( $request );
    }

    //获取令牌
    public function ComponentApiComponentToken( $component_verify_ticket ){
        $request = new ComponentApiComponentToken();
        $request->setComponentAppid( $this->appid );
        $request->setComponentAppSecret( $this->secret );
        $request->setComponentVerifyTicket( $component_verify_ticket );
        return $this->request( $request );
    }

    //获取预授权码
    public function ComponentApiCreatePreAuthCode( $component_access_token ){
        $request = new ComponentApiCreatePreAuthCode();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        return $this->request( $request );
    }

    //使用授权码获取授权信息
    public function ComponentApiQueryAuth( $component_access_token, $auth_code ){
        $request = new ComponentApiQueryAuth();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        $request->setAuthorizationCode($auth_code);
        return $this->request( $request );
    }

    //获取/刷新接口调用令牌
    public function ComponentApiAuthorizerToken( $component_access_token, $authorizer_appid, $authorizer_refresh_token ){
        $request = new ComponentApiAuthorizerToken();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        $request->setAuthorizerAppid($authorizer_appid);
        $request->setAuthorizerRefreshToken($authorizer_refresh_token);
        return $this->request( $request );
    }

    //获取授权方的帐号基本信息
    public function ComponentApiGetAuthorizerInfo( $component_access_token, $authorizer_appid ){
        $request = new ComponentApiGetAuthorizerInfo();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        $request->setAuthorizerAppid($authorizer_appid);
        return $this->request( $request );
    }

    //获取授权方选项信息
    public function ComponentApiGetAuthorizerOption( $component_access_token, $authorizer_appid, $option_name ){
        $request = new ComponentApiGetAuthorizerOption();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        $request->setAuthorizerAppid($authorizer_appid);
        $request->setOptionName($option_name);
        return $this->request( $request );
    }

    //设置授权方选项信息
    public function ComponentApiSetAuthorizerOption( $component_access_token, $authorizer_appid, $option_name, $option_value ){
        $request = new ComponentApiSetAuthorizerOption();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        $request->setAuthorizerAppid($authorizer_appid);
        $request->setOptionName($option_name);
        $request->setOptionValue($option_value);
        return $this->request( $request );
    }

    //拉取所有已授权的帐号信息
    public function ComponentApiGetAuthorizerList( $component_access_token, $offset, $count ){
        $request = new ComponentApiGetAuthorizerList();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        $request->setOffset($offset);
        $request->setCount($count);
        return $this->request( $request );
    }


    //创建开放平台帐号并绑定公众号/小程序
    public function OpenCreate( $access_token, $appid ){
        $request = new OpenCreate();
        $request->setAccessToken($access_token);
        $request->setAppid($appid);
        return $this->request( $request );
    }

    //将公众号/小程序绑定到开放平台帐号下
    public function OpenBind( $access_token, $appid, $open_appid ){
        $request = new OpenBind();
        $request->setAccessToken($access_token);
        $request->setAppid($appid);
        $request->setOpenAppid($open_appid);
        return $this->request( $request );
    }

    //将公众号/小程序从开放平台帐号下解绑
    public function OpenUnbind( $access_token, $appid, $open_appid ){
        $request = new OpenUnbind();
        $request->setAccessToken($access_token);
        $request->setAppid($appid);
        $request->setOpenAppid($open_appid);
        return $this->request( $request );
    }

    //获取公众号/小程序所绑定的开放平台帐号
    public function OpenGet( $access_token, $appid ){
        $request = new OpenGet();
        $request->setAccessToken($access_token);
        $request->setAppid($appid);
        return $this->request( $request );
    }

    //公众号通过 code 换取 access_token
    public function SnsOauth2AccessToken( $code ){
        $request = new SnsOauth2AccessToken();
        $request->setAppid($this->appid);
        $request->setSecret($this->secret);
        $request->setCode($code);
        return $this->request( $request );
    }

    //第三方代公众号通过 code 换取 access_token
    public function SnsOauth2ComponentAccessToken( $component_access_token, $appid, $code ){
        $request = new SnsOauth2ComponentAccessToken();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        $request->setAppid($appid);
        $request->setCode($code);
        return $this->request( $request );
    }

    //第三方代公众号刷新access_token
    public function SnsOauth2ComponentRefreshToken( $component_access_token, $appid, $refresh_token ){
        $request = new SnsOauth2ComponentRefreshToken();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        $request->setAppid($appid);
        $request->setRefreshToken($refresh_token);
        return $this->request( $request );
    }

    //通过网页授权 access_token 获取用户基本信息
    public function SnsUserInfo( $access_token, $openid ){
        $request = new SnsUserInfo();
        $request->setAccessToken($access_token);
        $request->setOpenid($openid);
        return $this->request( $request );
    }

    //小程序登录
    public function SnsJscode2Session( $js_code ){
        $request = new SnsJscode2Session();
        $request->setAppid($this->appid);
        $request->setSecret($this->secret);
        $request->setJsCode($js_code);
        return $this->request( $request );
    }

    //第三方代小程序登录
    public function SnsComponentJscode2Session( $component_access_token, $appid, $js_code ){
        $request = new SnsComponentJscode2Session();
        $request->setComponentAppid($this->appid);
        $request->setComponentAccessToken($component_access_token);
        $request->setAppid($appid);
        $request->setJsCode($js_code);
        return $this->request( $request );
    }


    //上传代码
    public function WxaCommit( $access_token, $template_id, $ext_json, $user_version, $user_desc ){
        $request = new WxaCommit();
        $request->setAccessToken($access_token);
        $request->setTemplateId($template_id);
        $request->setExtJson(json_encode($ext_json));
        $request->setUserVersion($user_version);
        $request->setUserDesc($user_desc);
        return $this->request( $request );
    }

    //获取已上传的代码的页面列表
    public function WxaGetPage( $access_token ){
        $request = new WxaGetPage();
        $request->setAccessToken($access_token);
        return $this->request( $request );
    }

    //获取体验版二维码
    public function WxaGetQrcode( $access_token ){
        $request = new WxaGetQrcode();
        $request->setAccessToken($access_token);
        return $this->request( $request );
    }

    //提交审核
    public function WxaCommitAudit( $access_token ){
        $request = new WxaCommitAudit();
        $request->setAccessToken($access_token);
        return $this->request( $request );
    }

    //查询指定发布审核单的审核状态
    public function WxaGetAuditStatus( $access_token, $auditid ){
        $request = new WxaGetAuditStatus();
        $request->setAccessToken($access_token);
        $request->setAuditid($auditid);
        return $this->request( $request );
    }

    //查询最新一次提交的审核状态
    public function WxaGetLatestAuditStatus( $access_token ){
        $request = new WxaGetLatestAuditStatus();
        $request->setAccessToken($access_token);
        return $this->request( $request );
    }

    //审核撤回
    public function WxaUndocodeaudit( $access_token ){
        $request = new WxaUndocodeaudit();
        $request->setAccessToken($access_token);
        return $this->request( $request );
    }

    //发布已通过审核的小程序
    public function WxaRelease( $access_token ){
        $request = new WxaRelease();
        $request->setAccessToken($access_token);
        return $this->request( $request );
    }


    //请求接口
    public function request( $request ){

        $action = $request->getAction();
        $url = $this->api_url . $action;

        $params = $request->getParams();
        if( !empty($params) ){
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $method = $request->getMethod();
        if( $method == 'post' ){
            $data = $request->getData();
            $postData = json_encode( (object)$data, JSON_UNESCAPED_UNICODE );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        $content = curl_exec($ch);
        curl_close($ch);

        $format = $request->getFormat();
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
