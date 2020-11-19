<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function versionList() {

	$client = new rabbitMQClient("Deployment.ini","deploymentServer");

	$request = array();
	$request['type'] = "versions";

	$retObj = $client->send_request($request);
	
	print_r($retObj['versions']);
}


versionList();



