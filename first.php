<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();

$response = $client->get('http://emag.ro');
echo $response->getStatusCode(), "\n";
// 200
echo $response->getEffectiveUrl();
// 'https://github.com/'
$body = $response->getBody();
echo $body;