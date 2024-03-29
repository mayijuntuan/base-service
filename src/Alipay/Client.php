<?php

namespace Mayijuntuan\Alipay;

use Mayijuntuan\Alipay\Requests\AlipaySystemOauthTokenRequest;
use Mayijuntuan\Alipay\Requests\AlipayUserInfoShareRequest;

use Mayijuntuan\Alipay\Requests\AlipayTradeWapPayRequest;
use Mayijuntuan\Alipay\Requests\AlipayTradeAppPayRequest;
use Mayijuntuan\Alipay\Requests\AlipayTradeCreateRequest;
use Mayijuntuan\Alipay\Requests\AlipayTradeRefundRequest;

use Mayijuntuan\Alipay\Requests\AlipayOpenAuthTokenAppRequest;
use Mayijuntuan\Alipay\Requests\AlipayOpenAuthTokenAppQueryRequest;


class Client{

    private $AopClient = null;
    private $app_auth_token = null;
    private $auth_app_id = null;

    private $app_id = '';
    private $private_key = '';
    private $alipay_public_key = '';
    private $charset = 'utf-8';
    private $sign_type = 'RSA2';

    public function __construct(){
        $this->AopClient = new AopClient();
        $this->AopClient->charset = $this->charset;
        $this->AopClient->signType = $this->sign_type;
    }

    public function setAppAuthToken( $app_auth_token ){
        $this->app_auth_token = $app_auth_token;
    }

    public function setAuthAppId( $auth_app_id ){
        $this->auth_app_id = $auth_app_id;
    }

    public function setAppId($app_id){
        $this->app_id = $app_id;
        $this->AopClient->appId = $app_id;
    }

    public function setPrivateKey($private_key){
        $this->private_key = $private_key;
        $this->AopClient->rsaPrivateKey = $private_key;
    }

    public function setAlipayPublicKey($alipay_public_key){
        $this->alipay_public_key = $alipay_public_key;
        $this->AopClient->alipayrsaPublicKey = $alipay_public_key;
    }

    public function setCharset($charset){
        $this->charset = $charset;
        $this->AopClient->charset = $this->charset;
    }

    public function setSignType($signType){
        $this->sign_type = $signType;
        $this->AopClient->signType = $signType;
    }


    //获取授权url
    public function getAuthUrl( $redirect_uri, $scope, $state='' ){
        $app_id = $this->app_id;
        if( !is_null($this->auth_app_id) ){
            $app_id = $this->auth_app_id;
        }
        $redirect_uri = urlencode($redirect_uri);
        $auth_url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm';
        return $auth_url . '?app_id=' . $app_id . '&scope=' . $scope . '&redirect_uri=' . $redirect_uri . '&state=' . $state;
    }

    //获取授权token
    public function SystemOauthToken( $auth_code ){
        $request = new AlipaySystemOauthTokenRequest();
        $request->setCode ( $auth_code );
        $request->setGrantType ( 'authorization_code' );
        return $this->execute( $request, null, $this->app_auth_token );
    }

    //获取用户信息
    public function UserInfoShare( $access_token ){
        $request = new AlipayUserInfoShareRequest();
        return $this->execute( $request, $access_token, $this->app_auth_token );
    }

    //发起网页支付
    public function TradeWapPay( $params, $return_url, $notify_url='' ){
        $request = new AlipayTradeWapPayRequest();
        $content = json_encode($params);
        $request->setBizContent($content);
        $request->setReturnUrl($return_url);
        if( !empty($notify_url) )
            $request->setNotifyUrl($notify_url);
        return $this->AopClient->pageExecute( $request, null, $this->app_auth_token );
    }

    //APP支付下单
    public function TradeAppPay( $params, $notify_url='' ){
        $request = new AlipayTradeAppPayRequest();
        $content = json_encode($params);
        $request->setBizContent($content);
        if( !empty($notify_url) )
            $request->setNotifyUrl($notify_url);
        return $this->execute( $request, null, $this->app_auth_token );
    }

    //统一支付下单
    public function TradeCreate( $params, $notify_url='' ){
        $request = new AlipayTradeCreateRequest();
        $content = json_encode($params);
        $request->setBizContent($content);
        if( !empty($notify_url) )
            $request->setNotifyUrl($notify_url);
        return $this->execute( $request, null, $this->app_auth_token );
    }

    //退款
    public function TradeRefund( $params ){
        $request = new AlipayTradeRefundRequest();
        $content = json_encode($params);
        $request->setBizContent($content);
        return $this->execute( $request, null, $this->app_auth_token );
    }


    //获取app授权url
    public function getAppAuthUrl( $redirect_uri, $application_type='MOBILEAPP,WEBAPP,PUBLICAPP,TINYAPP,ARAPP', $state='' ){
        $app_id = $this->app_id;
        $redirect_uri = urlencode($redirect_uri);
        $auth_url = 'https://openauth.alipay.com/oauth2/appToAppAuth.htm';
        return $auth_url . '?app_id=' . $app_id . '&redirect_uri=' . $redirect_uri . '&application_type=' . $application_type . '&state=' . $state;
    }

    //获取app批量授权url
    public function getAppBatchAuthUrl( $redirect_uri, $application_type='MOBILEAPP,WEBAPP,PUBLICAPP,TINYAPP,ARAPP', $state='' ){
        $app_id = $this->app_id;
        $redirect_uri = urlencode($redirect_uri);
        $auth_url = 'https://openauth.alipay.com/oauth2/appToAppBatchAuth.htm';
        return $auth_url . '?app_id=' . $app_id . '&redirect_uri=' . $redirect_uri . '&application_type=' . $application_type . '&state=' . $state;
    }

    //获取app授权token
    public function OpenAuthTokenApp( $app_auth_code ){
        $request = new AlipayOpenAuthTokenAppRequest();
        $content = array(
            'grant_type' => 'authorization_code',
            'code' => $app_auth_code,
        );
        $content = json_encode($content);
        $request->setBizContent($content);
        return $this->execute( $request );
    }

    //获取app授权的权限信息
    public function OpenAuthTokenAppQuery( $app_auth_token ){
        $request = new AlipayOpenAuthTokenAppQueryRequest();
        $content = array(
            'app_auth_token' => $app_auth_token,
        );
        $content = json_encode($content);
        $request->setBizContent($content);
        return $this->execute( $request );
    }


    //回调校验
    public function rsaCheckV1( $params ){
        return $this->AopClient->rsaCheckV1( $params, null, $params['sign_type'] );
    }

    //网关消息验证
    public function rsaCheckV2( $params ){
        return $this->AopClient->rsaCheckV2( $params, null, $params['sign_type'] );
    }

    public function gateway_service_check( $is_sign_success=true ){

        $alipay_public_key = $this->alipay_public_key;
        $sign_type = $this->sign_type;
        $charset = $this->charset;

        if ( $is_sign_success ) {
            $response_xml = "<success>true</success><biz_content>" . $alipay_public_key . "</biz_content>";
        } else { // echo $response_xml;
            $response_xml = "<success>false</success><error_code>VERIFY_FAILED</error_code><biz_content>" . $alipay_public_key . "</biz_content>";
        }
        $sign = $this->AopClient->sign( $response_xml, $sign_type );
        $return_xml = "<?xml version=\"1.0\" encoding=\"" . $charset . "\"?><alipay><response>" . $response_xml . "</response><sign>" . $sign . "</sign><sign_type>" . $sign_type . "</sign_type></alipay>";
        echo $return_xml;
        exit;

    }

    public function gateway_ack( $xml ){

        $create_time = $this->msectime();

        $return_xml = '<XML>';
        $return_xml .= '<ToUserId><![CDATA[' . $xml->FromAlipayUserId . ']]></ToUserId>';
        $return_xml .= '<AppId><![CDATA[' . $xml->AppId . ']]></AppId>';
        $return_xml .= '<CreateTime><![CDATA[' . $create_time . ']]></CreateTime>';
        $return_xml .= '<MsgType><![CDATA[ack]]></MsgType>';
        $return_xml .= '</XML>';
        echo $return_xml;
        exit;

    }

    private function msectime(){
        list($msec, $sec) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }

    //执行请求
    public function execute( $request, $auth_token=null, $app_auth_token=null){
        $result = $this->AopClient->execute( $request, $auth_token, $app_auth_token );
        $responseNode = str_replace( '.', '_', $request->getApiMethodName()) . '_response';
        if( empty($result->$responseNode) ){
            throw new \Exception('支付宝接口错误:' . json_encode( $result, JSON_UNESCAPED_UNICODE ) );
        }
        if( !empty($result->$responseNode->code) && $result->$responseNode->code != 10000 ){
            throw new \Exception('支付宝接口返回状态码错误:' . json_encode( $result->$responseNode,JSON_UNESCAPED_UNICODE) );
        }
        return $result->$responseNode;
    }

}
