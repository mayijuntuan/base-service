<?php

require_once __DIR__.'/../vendor/autoload.php';

use Mayijuntuan\Storage\Client;


$driver = 'oss';
$config = [
    'accesskey_id' => '',
    'accesskey_secret' => '',
    'endpoint' => '',
    'bucket' => '',
    'url' => '',
];
$client = new Client( $driver, $config );


$prefix = '';
$res = $client->listFiles( $prefix );
var_dump($res);


$key = 'abcd.jpg';
$filePath = '';
$res = $client->upload( $key, $filePath );
var_dump($res);
