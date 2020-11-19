<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');



function packandship($versionNum) {
	


	# here
	$fullname = 'webPackage'.$versionNum.'.tar.gz';

	# create & run shell command to compress needed directories
	$compress = 'tar -czf '.$fullname.' /var/www/html/stockTracker /home/matt00/Downloads/git/rabbitMQMerged /home/matt00/Downloads/git/installscript.sh';
	shell_exec(escapeshellcmd($compress));

	# create & run shell command to send package to Deployment box
	$deliver = 'scp '.$fullname.
		' matt@192.168.1.183:/home/matt/git/packages';
	shell_exec(escapeshellcmd($deliver));

	# create & run shell command to remove package from local machine 
	$tidy = 'rm '.$fullname;
	shell_exec(escapeshellcmd($tidy));

	return $fullname
}


function versionupdate($versionID) {

	$fname = packandship($versionID);
	
	$client = new rabbitMQClient("Deployment.ini", "deploymentServer");

        $req = array();
	$req['type'] = 'index';
	$req['version'] = $fname;

        $response = $client->send_request($req);
	$level = $response['messages'];
	
	echo PHP_EOL . PHP_EOL . "Error:  " . $level['errmsg'] . PHP_EOL;
	echo "Confirmation:  " . $level['conf'] . PHP_EOL;
	}


versionupdate($argv[1]);



