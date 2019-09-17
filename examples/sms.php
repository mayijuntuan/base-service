<?php

require_once __DIR__.'/../vendor/autoload.php';

use Mayijuntuan\Sms\Client;


$smsConfig = [
    'driver' => 'alibaba',
    'alibaba' => [
        'accesskey_id' => '',
        'accesskey_secret' => '',
        'sign' => '',
    ],
];
Client::setConfig($smsConfig);

$code = 86;
$mobile = '';

$templateCode = '';

$verify_code = rand(10000,99999);
$templateParams = [
    'code' => $verify_code,
];
$res = Client::staticSendTemplate( $code, $mobile, $templateCode, $templateParams );

var_dump($res);
