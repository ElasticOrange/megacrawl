<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Sunra\PhpSimple\HtmlDomParser;

$client = new Client();

$response = $client->get('http://emag.ro');
echo $response->getStatusCode(); // 200
echo $response->getEffectiveUrl(); // 'https://github.com/'
$body = $response->getBody();

print($body);