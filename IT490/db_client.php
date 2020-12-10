#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function updateLog($errmsg) {
	# with this a+ opening mode we APPEND to this existing logbook
	$newentry = fopen("/home/matt/logbook.txt", "a+");
	fwrite($newentry, $errmsg ."/n");
	fclose($newentry);
}

function doItAll($a, $b) {
$client = new rabbitMQClient("db_server.ini","dbServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "login";
$request['username'] = $a;
$request['password'] = $b;
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

#echo "client received response: ".PHP_EOL;
#print_r($response);
#echo "\n\n";
updateLog($response['message'])
return $response['message'];
#echo $argv[0]." END".PHP_EOL;

}
