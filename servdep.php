#!/usr/bin/php
<?php
session_start();
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

# this code assumes that there is a running database on the system named 
# packages, with a table called versions. Versions has timestamped rows
# with the numbered listing of in this case the web server  

unction updateLog($errmsg) {
	# with this a+ opening mode we APPEND to this existing logbook
	$newentry = fopen("/home/matt/logbook.txt", "a+");
	fwrite($newentry, $errmsg ."/n");
	fclose($newentry);

function indexWebPackage($version)
	{
 
	$ret = array();
	$ret['errmsg'] = 'none';
	$mysqli = new mysqli('localhost', 'matt', 'toor', 'packages');

    if ($mysqli->connect_errno) {
	
	    $ret['errmsg'] = "Error from DB: 
		    failed to connect to Deployment DB ";
	    updateLog($ret['errmsg'] . date("H:i:s"));
	    return;

				    }

    if ($mysqli->query("INSERT INTO packages.versions
	    (PackageLocation) values ('/home/matt/git/packages/webPackage$version.tar.gz')")) 
		{
	  
	    $ret['conf'] = ('Packaged received and indexed at ' .
		    date("H:i:s"));
    		}
	
    else {
    	$ret['errmsg'] = "Error from Deploymemt DB:
		Could not index new package." . date("H:i:s");
	updateLog($ret['errmsg']);
    
    }
	return $ret;

	} # end indexwebPackage


function sendVersions() {
	$mysqli = new mysqli('localhost', 'matt', 'toor', 'packages');

        if ($mysqli->connect_errno) {

            $ret['errmsg'] = "Error from DB: 
                    failed to connect to Deployment DB " . date("H:i:s");
            updateLog($ret['errmsg']);
            return; }     
                                    
	$sql = "select SubmitDate, PackageLocation from packages.versions";
	if ($retrows = $mysqli -> query($sql)){
		$versArr = array();
		$count = 0;
		
		while ($row = $retrows -> fetch_row()) {
			$versArr[$count] = [$row[0], $row[1]];
			$count++; }
		return $versArr; }
	
} # end sendVersions
	    


function requestProcessor($request)
{
  echo "received request".PHP_EOL;

  $retString = "error from deployment server. ";
  
  var_dump($request);
  
  if(!isset($request['type']))
   
  { 
    updateLog("ERROR: unsupported message type");
    return "ERROR: unsupported message type";
  }
  
  switch ($request['type'])
  
  {

    case "index":
	
	    $stash =  indexwebpackage($request['version']);
	    return array('messages' => $stash);
 	    break;	    

   case "versions":
	   $vIndex = sendVersions();
	   return array('versions' => $vIndex);
	   break;	   
  }

}

$server = new rabbitMQServer("Deployment.ini","deploymentServer");

echo 'Deployment server start ' . PHP_EOL;

$server->process_requests('requestProcessor');

echo "Database Server END".PHP_EOL;

exit();
?>
