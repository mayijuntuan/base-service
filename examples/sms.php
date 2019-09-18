<?php

require_once __DIR__.'/../vendor/autoload.php';

use Mayijuntuan\Sms\Client;


$driver = 'alibaba';
$config = [
    'accesskey_id' => '',
    'accesskey_secret' => '',
    'sign' => '',
];
$client = new Client( $driver, $config );

$code = 86;
$mobile = '';

$templateCode = '';

$verify_code = rand(10000,99999);
$templateParams = [
    'code' => $verify_code,
];
$res = $client->sendTemplate( $code, $mobile, $templateCode, $templateParams );

var_dump($res);
