#!/usr/bin/php
<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

# this code assumes that there is a running database on the system named 
# packages, with a table called versions. Versions has timestamped rows
# with the numbered listing of in this case the web server  

function indexWebPackage($version)
	{
 
	$ret = array();
	$ret['errmsg'] = 'none';
	$mysqli = new mysqli('localhost', 'matt', 'toor', 'packages');

    if ($mysqli->connect_errno) {
	
	    $ret['errmsg'] = "Error from DB: 
		    failed to connect to Deployment DB ";
		return;     # FIX  updateLog($ret0 . date("H:i:s"));

				    }

    if ($retrow = $mysqli->query("INSERT INTO packages.versions
	    (PackageLocation) values ('/home/matt/git/packages/webPackage$version.tar.gz')")) 
		{
	  
	    $ret['conf'] = ('Packaged received and indexed at ' .
		    date("H:i:s"));
    		}
	
    else {
    	$ret['errmsg'] = "Error from Deploymemt DB:
		Could not index new package." . date("H:i:s");
    
    }
	return $ret;

	}

	    


function requestProcessor($request)
{
  echo "received request".PHP_EOL;

  $retString = "error from deployment server. ";
  
  var_dump($request);
  
  if(!isset($request['type']))
  
  {
    return "ERROR: unsupported message type";
  }
  
  switch ($request['type'])
  
  {

    case "index":
	
	    $stash =  indexwebpackage($request['version']);
 	    break;	    

   case "pull":
   	# fill
	break;	   
  }



  return array('messages' => $stash);
}

$server = new rabbitMQServer("Deployment.ini","deploymentServer");

echo 'Deployment server start ' . PHP_EOL;

$server->process_requests('requestProcessor');

echo "Database Server END".PHP_EOL;

exit();
?>
