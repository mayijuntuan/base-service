<?php

namespace Mayijuntuan\Weixin;

use Mayijuntuan\Weixin\Pay\UnifiedOrder;
use Mayijuntuan\Weixin\Pay\JsApiPay;
use Mayijuntuan\Weixin\Pay\Refund;
use Mayijuntuan\Weixin\Pay\Results;


class PayClient{

    private $api_url = 'https://api.mch.weixin.qq.com';
    private $appid = '';
    private $mch_id = '';
    private $sub_appid = '';
    private $sub_mch_id = '';
    private $key = '';
    private $sslcertPath = '';
    private $sslkeyPath = '';
    private $sslkeyPasswd = '';

    public function setAppid($appid){
        $this->appid = $appid;
    }

    public function setMchId($mch_id){
        $this->mch_id = $mch_id;
    }

    public function setSubAppid($sub_appid){
        $this->sub_appid = $sub_appid;
    }

    public function setSubMchId($sub_mch_id){
        $this->sub_mch_id = $sub_mch_id;
    }

    public function setKey($key){
        $this->key = $key;
    }

    public function setSslCertPath($sslcertPath){
        $this->sslcertPath = $sslcertPath;
    }

    public function setSslKeyPath($sslkeyPath){
        $this->sslkeyPath = $sslkeyPath;
    }

    public function setSslKeyPasswd($sslkeyPasswd){
        $this->sslkeyPasswd = $sslkeyPasswd;
    }


    /**
     *
     * 获取jsapi支付的参数
     * @return json数据，可直接填入js函数作为参数
     */
    public function getJsApiParameters( $trade_no, $title, $amount, $notify_url, $trade_type, $openid='' ){

        //统一下单
        $action = '/pay/unifiedorder';

        //参数
        $input = new UnifiedOrder();
        $input->SetBody($title);
        $input->SetOut_trade_no($trade_no);
        $input->SetTotal_fee($amount);
        $input->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);
        $input->SetTime_start(date('YmdHis'));
        $input->SetTime_expire(date('YmdHis', time() + 600));
        $input->SetNotify_url( $notify_url );
        $input->SetTrade_type($trade_type);

        if( !empty($this->sub_appid) ){
            $input->SetSub_appid($this->sub_appid);
            $input->SetSub_mch_id($this->sub_mch_id);
            if( !empty($openid) )
                $input->SetSub_openid($openid);
        }else{
            if( !empty($openid) )
                $input->SetOpenid($openid);
        }

        $UnifiedOrderResult = $this->api( $action, $input);
        if( empty($UnifiedOrderResult['prepay_id']) )
            throw new \Exception("支付下单失败");
        $prepay_id = $UnifiedOrderResult['prepay_id'];

        $appid = empty($this->sub_appid) ? $this->appid : $this->sub_appid;

        $jsapi = new JsApiPay();
        $jsapi->SetKey($this->key);
        $jsapi->SetAppid($appid);
        $timeStamp = ''.time();
        $jsapi->SetTimeStamp($timeStamp);
        $jsapi->SetNonceStr($this->getNonceStr());
        $jsapi->SetPackage('prepay_id=' . $prepay_id);
        $jsapi->SetSignType('MD5');
        $jsapi->SetPaySign($jsapi->MakeSign());
        $parameters = $jsapi->GetValues();
        return $parameters;

    }

    /**
     *
     * 支付回调
     */
    public function notifyCheck(){

        $content = file_get_contents('php://input');

        $results = new Results();
        $results->SetKey($this->key);
        return $results->Init($content);

    }

    /**
     *
     * 退款
     */
    public function refund( $refund_no, $trade_no, $amount, $totalAmount ){

        $action = '/secapi/pay/refund';

        //参数
        $input = new Refund();
        $input->SetOut_refund_no($refund_no);
        $input->SetOut_trade_no($trade_no);
        $input->SetTotal_fee($totalAmount);
        $input->SetRefund_fee($amount);

        if( !empty($this->sub_appid) ){
            $input->SetSub_appid($this->sub_appid);
            $input->SetSub_mch_id($this->sub_mch_id);
        }

        $RefundResult = $this->api( $action, $input, true );
        return $RefundResult;

    }

    /**
     *
     * 退款回调
     */
    public function refundNotifyCheck(){

        $content = file_get_contents('php://input');

        $results = new Results();
        $results->SetKey($this->key);
        $results->FromXml($content);
        $result = $results->GetValues();

        $req_info = $result['req_info'];
        $req_info = openssl_decrypt( base64_decode($req_info), 'aes-256-ecb', md5($this->key), OPENSSL_RAW_DATA );
        $results->FromXml($req_info);
        $req_info = $results->GetValues();
        $result['req_info'] = $req_info;

        return $result;

    }


    private function getNonceStr($length = 32){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    private function api( $action, $input, $useCert=false ){

        $url = $this->api_url . $action;
        $response = $this->sendXml( $url, $input, $useCert );

        $results = new Results();
        $results->SetKey($this->key);
        $result = $results->Init($response);

        if( $result['return_code'] != 'SUCCESS' ){
            throw new \Exception( '返回结果错误，错误信息:' . $result['return_msg'] );
        }
        if( $result['result_code'] != 'SUCCESS' ){
            throw new \Exception( '请求结果错误，错误代码:' .$result['err_code'] . ',错误描述:' . $result['err_code_des'] );
        }

        return $result;

    }

    private function sendXml( $url, $input, $useCert=false ){

        $input->SetKey($this->key);
        $input->SetAppid($this->appid);
        $input->SetMch_id($this->mch_id);
        $input->SetNonce_str($this->getNonceStr()); //随机字符串

        //签名
        $input->SetSign();
        $xml = $input->ToXml();

        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 10 );

        curl_setopt($ch,CURLOPT_URL, $url );
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM' );
            curl_setopt($ch,CURLOPT_SSLCERT, $this->sslcertPath );
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM' );
            curl_setopt($ch,CURLOPT_SSLKEY, $this->sslkeyPath );
            if( !empty($this->sslkeyPasswd) ){
                curl_setopt($ch,CURLOPT_KEYPASSWD, $this->sslkeyPasswd );
            }
        }

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        $errorno = curl_errno($ch);
        $code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);

        if( $errorno ){
            throw new \Exception('curl返回错误'.$errorno );
        }
        if( $code != 200 ){
            throw new \Exception('curl返回状态码错误'.$code );
        }

        return $data;

    }

}
