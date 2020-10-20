#!/usr/bin/php
<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function callDB($input) {

	$client = new rabbitMQClient("db_server.ini","dbServer");

	return $client->send_request($input);

	}


function callDMZ($input) {

        $client = new rabbitMQClient("dmzServer.ini","dmzServer");

        return $client->send_request($input);
	}


function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }

  switch ($request['type'])
  {
 
  	case "login":
		return callDB($request);
		break;
	case "dmz":
		return callDMZ($request);
		break;
   }
}

$server = new rabbitMQServer("webconn.ini","testServer");

echo "Switching Server BEGIN".PHP_EOL;

$server->process_requests('requestProcessor');

echo "Switching server  END".PHP_EOL;

exit();

?>
