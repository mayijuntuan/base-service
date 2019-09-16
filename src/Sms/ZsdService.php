<?php

namespace Mayijuntuan\Sms;


class ZsdService{

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    private function getConfig(){
        return $this->config;
    }

    /**
     * 发送短信
     *
     * @param $filename
     * @return string
     */
    public function send( $code, $mobile, $content ){

        if( $code != '86' ){
            $this->error = '不支持国际手机号码';
            return false;
        }

		$config = $this->getConfig();

		$content = $config['sign'] . $content;

		$params = array(
            'action' => 'send',
            'userid' => $config['userid'],
			'mobile' => $mobile,
			'content' => $content,
			'sendTime' => '',
            'extno' => '',
		);

        return $this->api($params);

	}//end function send


    public function sendStatus( $msgid ){

		$params = [
            'msgid' => $msgid,
        ];
        return $this->api($params);

	}//end function sendstatus


    public function balance(){
		return $this->api();
	}//end function balance


    private function api( $params=[] ){

        $config = $this->getConfig();

        $params['account'] = $config['account'];
        $params['password'] = $config['password'];

        $query = http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $config['url'].'?'.$query );
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        $curl_error = curl_error($ch);
        curl_close($ch);
        if( $curl_error ){
            $this->error = '请求结果出错'.$curl_error;
            return false;
        }
        if( $httpcode != 200 ){
            $this->error = '返回http状态码错误'.$httpcode;
            return false;
        }

        return $result;
    }

}
