#!/usr/bin/php
<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function updateLog($errmsg) {
	# with this a+ opening mode we APPEND to this existing logbook
	$stamp = date("H:i:s");
	$newentry = fopen("/home/matt/logbook.txt", "a+");
	fwrite($newentry, $errmsg ."/n");
	fclose($newentry);

}

function callDB($input) {

	$client = new rabbitMQClient("db_server.ini","dbServer");
	updateLog("callingDB\t");
	return $client->send_request($input);

	}


function callDMZ($input) {

        $client = new rabbitMQClient("dmzServer.ini","dmzServer");
	updateLog("callingDMZ");
        return $client->send_request($input);
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);

  if(!isset($request['type']))
  {
    updateLog("ERROR: unsupported message type");
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
	
	case "ref":
		return 5;
		break;
   }
}

$server = new rabbitMQServer("webconn.ini","testServer");

echo "Switching Server BEGIN".PHP_EOL;

$server->process_requests('requestProcessor');

echo "Switching server  END".PHP_EOL;

exit();

?>
