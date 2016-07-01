<?php
require_once("src/JWT.php");

use \Firebase\JWT\JWT;

$key = "example_key";
$token = array(
    "iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000
);

// http://172.18.182.46:7100/#!/control/172.18.176.133:5555
$token = array(
    "name" => "liufuxin_jwt",
    "email" => "liufuxin_jwt@baidu.com",
    "url" => "/#!/control/172.18.176.133:5555",
);
$jwt = JWT::encode($token, "pluto_stf_auth_secret");
echo $jwt;	//eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoibGl1ZnV4aW5fand0IiwiZW1haWwiOiJsaXVmdXhpbl9qd3RAYmFpZHUuY29tIiwidXJsIjoiXC8jIVwvY29udHJvbFwvMTcyLjE4LjE3Ni4xMzM6NTU1NSJ9.Z4yfuwBv13YxR8h63U66dSZ8QJ1-NXqstcPJudiNshc
die();

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = JWT::encode($token, $key);
$decoded = JWT::decode($jwt, $key, array('HS256'));

print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, $key, array('HS256'));

?>