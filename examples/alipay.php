<?php

require_once __DIR__.'/../vendor/autoload.php';

use Mayijuntuan\Alipay\AopClient;


$client = new AopClient;

$client->appId = '';
$client->rsaPrivateKey = '';


$request = new AlipayOpenPublicFollowBatchqueryRequest();

$content = array(
    'next_user_id' => '',
);
$content = json_encode($content);
$request->setBizContent($content);

$auth_token = null;
$app_auth_token = null;

$res = $client->execute( $request, $auth_token, $app_auth_token );
var_dump($res);
