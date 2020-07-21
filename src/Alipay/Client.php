<?php

namespace App\Services\Alipay;

use Mayijuntuan\Alipay\Request\AlipaySystemOauthTokenRequest;
use Mayijuntuan\Alipay\Request\AlipayUserInfoShareRequest;

use Mayijuntuan\Alipay\Request\AlipayOpenAuthTokenAppRequest;
use Mayijuntuan\Alipay\Request\AlipayOpenPublicInfoQueryRequest;
use Mayijuntuan\Alipay\Request\AlipayOpenPublicInfoModifyRequest;
use Mayijuntuan\Alipay\Request\AlipayOpenPublicFollowBatchqueryRequest;
use Mayijuntuan\Alipay\Request\AlipayOpenPublicMenuBatchqueryRequest;

use Mayijuntuan\Alipay\Request\AlipayTradeWapPayRequest;
use Mayijuntuan\Alipay\Request\AlipayTradeCreateRequest;
use Mayijuntuan\Alipay\Request\AlipayTradeRefundRequest;

use Exception;


class Client{

    private $AopClient = null;
    private $auth_url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm';
    private $app_auth_url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm';
    private $alipay_public_key = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqilBTZlhe2pXhwUyvhagm7s3u/ZNBK4TgBu1MFL+7LHTeP+zDgLQ9l/Z0GSskCqx65inv1u7gsav40p6nSR/m4eV5ZFNHT3F8W6Y/u0XNncqcEhWQfwl12cBEfp/m9D4ybE14hPNCxivhw2YNLi8/U8fhdViG7+BGEuI5BFfx0Scim/1XovwuwF083Np5vbHdTvb0/JzRl43VcJQ5YXqJyI850RRnoTD4x+b6/b9X3tGxV7REOcRHoBWhPUuB18/0QlX9hkGxn9A2UCwXaZjRXdEv/MVyv3C2mwRsLKM9ImYJM2jPdpUQqyq2S1AQP0dGPufJa6eXS6C9+Fh2n+0owIDAQAB';

    private $app_id = '';
    private $private_key = '';
    private $public_key = '';
    private $charset = 'utf-8';
    private $sign_type = 'RSA2';

    public function __construct( $config ){
        $this->AopClient = new AopClient();
        $this->setAliapyPublicKey();
        $this->setAppId($config['app_id']);
        $this->setPrivateKey($config['private_key']);
        $this->setPublicKey($config['public_key']);
        $this->setCharset($config['charset']);
        $this->setSignType($config['sign_type']);
    }

    private function setAliapyPublicKey(){
        $this->AopClient->alipayrsaPublicKey = $this->alipay_public_key;
    }

    private function setAppId($app_id){
        $this->app_id = $app_id;
        $this->AopClient->appId = $app_id;
    }

    private function setPrivateKey($private_key){
        $this->private_key = $private_key;
        $this->AopClient->rsaPrivateKey = $private_key;
    }

    private function setPublicKey($public_key){
        $this->public_key = $public_key;
    }

    private function setCharset($charset){
        $this->charset = $charset;
        $this->AopClient->charset = $charset;
    }

    private function setSignType($sign_type){
        $this->sign_type = $sign_type;
        $this->AopClient->signType = $sign_type;
    }


    //获取授权url
    public function getAuthUrl( $redirect_uri, $scope, $state='' ){
        $app_id = $this->app_id;
        $redirect_uri = urlencode($redirect_uri);
        return $this->auth_url . '?app_id=' . $app_id . '&scope=' . $scope . '&redirect_uri=' . $redirect_uri . '&state=' . $state;
    }

    //获取授权token
    public function getAuthToken( $auth_code ){
        $request = new AlipaySystemOauthTokenRequest();
        $request->setCode ( $auth_code );
        $request->setGrantType ( 'authorization_code' );
        return $this->execute( $request );
    }

    //获取用户信息
    public function getUserInfo( $access_token ){
        $request = new AlipayUserInfoShareRequest();
        return $this->execute( $request, $access_token );
    }

    //发起网页支付
    public function tradeWapPay( $params, $notify_url, $return_url ){
        $request = new AlipayTradeWapPayRequest();
        $content = json_encode($params);
        $request->setBizContent($content);
        $request->setNotifyUrl($notify_url);
        $request->setReturnUrl($return_url);
        return $this->AopClient->pageExecute($request);
    }

    //支付下单
    public function tradeCreate( $params, $notify_url ){
        $request = new AlipayTradeCreateRequest();
        $content = json_encode($params);
        $request->setBizContent($content);
        $request->setNotifyUrl($notify_url);
        return $this->execute( $request );
    }

    //退款
    public function tradeRefund( $params ){
        $request = new AlipayTradeRefundRequest();
        $content = json_encode($params);
        $request->setBizContent($content);
        return $this->execute( $request );
    }

    //支付回调
    public function payNotify(){
        return $this->AopClient->rsaCheckV1( $_POST, null, $this->sign_type );
    }

    //获取app授权url
    public function getAppAuthUrl( $redirect_uri ){
        $app_id = $this->app_id;
        $redirect_uri = urlencode($redirect_uri);
        return $this->app_auth_url . '?app_id=' . $app_id . '&redirect_uri=' . $redirect_uri;
    }

    //获取app授权token
    public function getAppAuthToken( $app_auth_code ){
        $request = new AlipayOpenAuthTokenAppRequest();
        $content = array(
            'grant_type' => 'authorization_code',
            'code' => $app_auth_code,
        );
        $content = json_encode($content);
        $request->setBizContent($content);
        return $this->execute( $request );
    }

    //获取app信息
    public function getAppInfo( $app_auth_token ){
        $request = new AlipayOpenPublicInfoQueryRequest();
        return $this->execute( $request, null, $app_auth_token );
    }

    //修改app信息
    public function modifyAppInfo( $params ){
        $request = new AlipayOpenPublicInfoModifyRequest();
        $content = json_encode($params);
        $request->setBizContent($content);
        return $this->execute( $request );
    }

    //获取app粉丝
    public function getAppFllow( $next_user_id='' ){
        $request = new AlipayOpenPublicFollowBatchqueryRequest();
        $content = array(
            'next_user_id' => $next_user_id,
        );
        $content = json_encode($content);
        $request->setBizContent($content);
        return $this->execute( $request );
    }

    //获取app菜单
    public function getAppMenu(){
        $request = new AlipayOpenPublicMenuBatchqueryRequest();
        return $this->execute( $request );
    }

    //消息网关
    public function gateway(){

        if( empty($_POST['sign']) )
            throw new Exception('parameter sign is empty');

        if( empty($_POST['sign_type']) )
            throw new Exception('parameter sign_type is empty');

        if( empty($_POST['service']) )
            throw new Exception('parameter service is empty');

        if( empty($_POST['charset']) )
            throw new Exception('parameter charset is empty');

        if( empty($_POST['biz_content']) )
            throw new Exception('parameter biz_content is empty');

        $res = $this->AopClient->rsaCheckV2( $_POST, null, $_POST['sign_type'] );
        if ( $_POST['service'] == 'alipay.service.check' ){
            return $this->gateway_service_check( $res );
        }
        if( !$res ) {
            throw new Exception('sign verfiy fail');
        }

        $biz_content = $_POST['biz_content'];
        if( strtolower($_POST['charset']) != 'utf-8' ){
            $biz_content = iconv( $_POST['charset'], 'UTF-8', $biz_content);
        }
        return simplexml_load_string($biz_content);

    }

    private function gateway_service_check( $is_sign_success ){

        $private_key = $this->private_key;
        $public_key = $this->public_key;
        $sign_type = $this->sign_type;
        $charset = $this->charset;

        if ( $is_sign_success ) {
            $response_xml = "<success>true</success><biz_content>" . $public_key . "</biz_content>";
        } else { // echo $response_xml;
            $response_xml = "<success>false</success><error_code>VERIFY_FAILED</error_code><biz_content>" . $public_key . "</biz_content>";
        }
        $sign = $this->sign( $response_xml, $private_key, $sign_type );
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
        return $return_xml;

    }

    //执行请求
    private function execute( $request, $auth_token=null, $app_auth_token=null){
        $result = $this->AopClient->execute( $request, $auth_token, $app_auth_token );
        $responseNode = str_replace( '.', '_', $request->getApiMethodName()) . '_response';
        if( empty($result->$responseNode) ){
            throw new Exception('支付宝接口错误:' . $result->error_response->sub_msg );
        }
        return $result->$responseNode;
    }

}
