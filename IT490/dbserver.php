#!/usr/bin/php

<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function chkcreds($userone, $passone)
{
    $ret = "error";
    $mysqli = new mysqli('localhost', 'testdb', 'data', 'vault');

    if ($mysqli->connect_errno) {
            $ret = "failed to connect to DB";

    }


    if ($retrow = $mysqli->query("SELECT * FROM vault.users WHERE username='$userone' and password = '$passone'")) {


	    $count = $retrow->num_rows;
	    $retrow->close;
	  
	    if ($count == 1) {
		    $ret = "success, logged in!";
	    }

	    else {
	    
	    $ret = "failure, no user found with those credentials";
	    }
    }

    return $ret;

}


function requestProcessor($request)
{
  echo "received request".PHP_EOL;

  $retString = "error";
  
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      $retString =  chkcreds($request['username'],$request['password']);	   
  }
  return array("returnCode" => '0',  'response' => $retString);
}

$server = new rabbitMQServer("db_server.ini","dbServer");

echo "Database Server".PHP_EOL;

$server->process_requests('requestProcessor');

echo "Database Server END".PHP_EOL;

exit();
?>
