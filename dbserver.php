#!/usr/bin/php
<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function updateLog($errmsg) {
	# with this a+ opening mode we APPEND to this existing logbook
	$newentry = fopen("/home/matt/logbook.txt", "a+");
	fwrite($newentry, $errmsg ."/n");
	fclose($newentry);

}


function chkcreds($userone, $passone)
{
 

    $ret = array();
    $ret['msg'] = "error, not logged in.";
    

    $mysqli = new mysqli('localhost', 'testdb', 'data', 'vault');

    if ($mysqli->connect_errno) {
<<<<<<< HEAD
	    $err0 = "Error from DB: failed to connect to DB      " 
		    . date("H:i:s");
	    $ret['msg'] = $err0;
	    return $ret; }

	# query for a uid which matches the passed credentials
    # hash passed password and compare with stored hash. 
    # Must be stored with 
    #
    # INSERT INTO db.table (username, password) VALUES ('un', SHA1('pw'));
    #
    else if ($retrow = $mysqli->query("SELECT uid FROM vault.users WHERE username='$userone' AND hex(password) = sha1('$passone')")) {
	# if the query returns any rows		
	   $count = $retrow->num_rows;
=======
	    $ret0 = "Error from DB: failed to connect to DB ";
	    $ret0 .= date("H:i:s");
	    updateLog($ret0);
	    
    }


    if ($retrow = $mysqli->query("SELECT publickey, privatekey FROM vault.users WHERE username='$userone' and password = '$passone'")) {


	    $count = $retrow->num_rows;

>>>>>>> e2f7b7e2f943572a8deccebf7a097b202255f06a
	    if ($r = $retrow->fetch_assoc()){
                        $ret['pubkey'] = $r['publickey'];
                        $ret['privkey'] = $r['privatekey'];
                        # updateLog();
            }

	   	   
	    
	  
	    if ($count == 1) {
		    $ret['msg'] = "success, logged in!";
	    }

	    else {
	    
		    $ret1 = "failure, no user found with those credentials";
		    $ret1 .=  date("H:i:s");
		    updateLog($ret1);
		    	    
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
  return array('msg' => $retCreds['msg'], 'pubkey'=>$retCreds['pubkey'] ?? '', 'privkey'=>$retCreds['privkey'] ?? '');
}

$server = new rabbitMQServer("db_server.ini","dbServer");

echo "Database Server".PHP_EOL;

$server->process_requests('requestProcessor');

echo "Database Server END".PHP_EOL;

exit();
?>
