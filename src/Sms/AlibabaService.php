<?php

namespace Mayijuntuan\Sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;


class AlibabaService{

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 发送短信
     *
     * @param $code
     * @param $mobile
     * @param $templateCode
     * @param $templateParams
     * @return string
     */
    public function sendTemplate( $code, $mobile, $templateCode, $templateParams ){

        if( $code != '86' )
            $mobile = $code . $mobile;

        $accessKeyId = $this->config['accesskey_id'];
        $accessKeySecret = $this->config['accesskey_secret'];
        AlibabaCloud::accessKeyClient( $accessKeyId, $accessKeySecret )
            ->regionId('default')
            ->asDefaultClient();

        return AlibabaCloud::rpc()
            ->product('Dysmsapi')
            // ->scheme('https') // https | http
            ->version('2017-05-25')
            ->action('SendSms')
            ->method('POST')
            ->host('dysmsapi.aliyuncs.com')
            ->options([
                'query' => [
                    'RegionId' => "default",
                    'PhoneNumbers' => $mobile,
                    'SignName' => $this->config['sign'],
                    'TemplateCode' => $templateCode,
                    'TemplateParam' => json_encode($templateParams),
                ],
            ])
            ->request();

	}//end function send

}
