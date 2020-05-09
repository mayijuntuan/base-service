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


$key = 'df4ff220d996fdb3373675518f78c14d.jpg';
$res = $client->delete( $key );
var_dump($res);


$prefix = '';
$res = $client->getList( $prefix );
var_dump($res);


exit;

$key = 'abcd.jpg';
$filePath = './abcd.jpg';
$res = $client->upload( $key, $filePath );
var_dump($res);
