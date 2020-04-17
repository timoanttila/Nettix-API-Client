<?php
function getKey($params){
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, "https://auth.nettix.fi/oauth2/token");
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt( $ch, CURLOPT_POSTFIELDS,$params);
	$result = json_decode(curl_exec($ch));
	curl_close($ch);
	return $result->access_token;
}

function getInfo($serv,$action,$headers){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.nettix.fi/rest/". $serv ."/". $action);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = json_decode(curl_exec($ch));
	curl_close($ch);
	return $result;
}

$params = array(
	"grant_type" => "client_credentials",
	"client_id" => "name",
	"client_secret" => "pass"
);

// Auth key
$key = getKey($params);

// New headers
$headers = ["Content-Type: application/x-www-form-urlencoded; charset=utf-8","X-Access-Token: ". $key];

// Get cars
$items = getInfo("car", "search?userId=123456", $headers);
