#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function updateLog($errmsg) {
	# with this a+ opening mode we APPEND to this existing logbook
	$newentry = fopen("/home/matt/git/logbook.txt", "a+");
	fwrite($newentry, $errmsg ."/n");
	fclose($newentry);

}


function chkcreds($userone, $passone) {
    $ret = array();
    $ret['msg'] = "error, not logged in.";
    $mysqli = new mysqli('localhost', 'matt', 'toor', 'vault');
    if ($mysqli->connect_errno) {
	    $err0 = "Error from DB: failed to connect to DB      " 
		    . date("H:i:s");
	    $ret['msg'] = $err0;
	    updateLog("returned uid 1");
	    return $ret; }

    $sql = "SELECT uid FROM vault.users WHERE username='$userone' AND hex(password) = sha1('$passone')";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	$ret['uid'] = $row['uid'];
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
      $retCreds =  chkcreds($request['username'],$request['password']);	   
  }
  return array('msg' => $retCreds['msg'], 'uid' => $retCreds['uid']);
}

$server = new rabbitMQServer("db_server.ini","dbServer");

echo "Database Server".PHP_EOL;

$server->process_requests('requestProcessor');

echo "Database Server END".PHP_EOL;

exit();
?>
