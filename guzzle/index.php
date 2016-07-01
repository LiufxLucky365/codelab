<?php
require_once('../vendor/autoload.php');

$client = new GuzzleHttp\Client();
$api = "http://mars.baidu.local.com/Pluto/addRecord/skip/PlutoAll";
$res = $client->request('GET', $api);
$json = $res->getBody();
echo $json;
die();

// Send an asynchronous request.
$request = new Request('GET', 'http://www.baidu.com');
$promise = $client->sendAsync($request)->then(function ($res) {
	echo $res->getStatusCode();
	print_r($res->getHeader('content-type'));
	$json = $res->getBody();
	print_r(json_decode($json, true));
});

echo 123;

$promise->wait();