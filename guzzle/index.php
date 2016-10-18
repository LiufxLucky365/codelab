<?php
require_once('../vendor/autoload.php');

$url = "http://www.baidu.com";

$client = new GuzzleHttp\Client();
$res = $client->request('GET', $url);
echo $res->getBody();

// Send an asynchronous request.
$request = new GuzzleHttp\Psr7\Request('GET', $url);
$promise = $client->sendAsync($request)->then(function ($res) {
	echo $res->getStatusCode();
	echo $res->getBody();
});
$promise->wait();