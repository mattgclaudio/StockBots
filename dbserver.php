#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function updateLog($errmsg) {
	# with this a+ opening mode we APPEND to this existing logbook
	$newentry = fopen("/home/matt/logbook.txt", "a+");
	fwrite($newentry, $errmsg);
	fclose($newentry);

}


function validate($userone, $passone)
{
 
	# check inputted credentials against those in the DB
	# create return array, error/success message and user id.
	#
    $ret = array();
    $ret['msg'] = " ";
    $ret['uid'] = NULL;

    # PHP connetion to DB
    $mysqli = new mysqli('localhost', 'matt', 'toor', 'vault');

    # catch clause for no DB connection, returns timestamped error message
    if ($mysqli->connect_errno) {
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
    else if ($retrow = $mysqli->query(
	    "SELECT uid FROM vault.users1 
	    WHERE username='$userone' 
		and password = SHA1('$passone')")) {
	# if the query returns any rows		
	   $count = $retrow->num_rows;
	    if ($r = $retrow->fetch_assoc()){
                        $ret['uid'] = $r["uid"];
			$ret['msg'] = "Success, logged in!";
			return $ret; }
	# if no rows
	    else {
		    $err1 = "failure, no user found with those credentials" .
			    date("H:i:s");    
		    $ret['msg'] = $err1;  }
    						}	
	
}


function requestProcessor($request)
{
  echo "received request".PHP_EOL;

  var_dump($request);

  if(!isset($request['type']))
  {
    $err01 = "ERROR: unsupported message type";
  }

  switch ($request['type'])
  {

  case "login":
     	  # Pass inputted credentials to validate(), 
	  # returns array with errors/uid, passes that directly back to the 
	  # web front end with 'msg' => $valres	
	  $valres = validate($request['username'],$request['password']);
	  return array('msg' => $valres, 'error' => $err01 ?? 
		  "Switch Type Valid" . date("H:i:s"));
	  break; 
  }
  
} # end requestProcessor

	
$server = new rabbitMQServer("db_server.ini","dbServer");

echo "Database Server".PHP_EOL;

$server->process_requests('requestProcessor');

echo "Database Server END".PHP_EOL;

exit();
?>
