<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');



function dologin($a, $b) {
	
	$client = new rabbitMQClient("rabbit.ini","testServer");

	$request = array();

	$request['type'] = "login";

	$request['username'] = $a;
	$request['password'] = $b;

	return $client->send_request($request);

		

}

function getcash ($p1, $p2) {

	$client = new rabbitMQClient("rabbit.ini", "testServer");

	$req = array();
	$req['type'] = "dmz";
	$req['pubkey'] = $p1;
	$req['privkey'] = $p2;
	$req['action'] = "cash";

	return $client->send_request($req);
}



