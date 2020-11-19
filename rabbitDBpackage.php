<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');



function packandship($versionid) {
	
	# So this function takes one parameter, a string version id for this 
	# package. It  creates shell commands and runs them, compressing the ~/git/RabbitServer and ~/gitUserDatabase directories, 
	# creat
	# scp'ing the package, 

	# here
	$fullname = 'rabbitDB'.$versionid.'.tar.gz';

	# dump the user database for transfer
	$userdb = 'mysqldump vault > userdb.sql';
	shell_exec(escapeshellcmd($userdb));

	# create & run shell command to compress needed directories
	$compress = 'tar -czf '.$fullname.' /home/matt/git/RabbitServer /home/matt/git/UserDatabase userdb.sql';
	shell_exec(escapeshellcmd($compress));

	# create & run shell command to send package to Deployment box
	$deliver = 'scp '.$fullname.
		' matt@192.168.1.183:/home/matt/git/packages';
	shell_exec(escapeshellcmd($deliver));

	# create & run shell command to remove package from local machine 
	$tidy = 'rm '.$fullname;
	shell_exec(escapeshellcmd($tidy));

	return $fullname;
}


function versionupdate($versionID) {

	$fname = packandship($versionID);
	# give the deployement vm the full name so it knows what the
	# full title will be. 
	
	$client = new rabbitMQClient("Local_Deployment.ini",
	       	"deploymentServer");

        $req = array();
	$req['type'] = 'index';
	$req['version'] = $fname;
	
	$response = $client->send_request($req);
	$level = $response['messages'];

	echo PHP_EOL . PHP_EOL . "Error:   " . $level['errmsg'] . PHP_EOL .
		"Confirmation:  " . $level['conf'] . PHP_EOL;
	
			}


versionupdate($argv[1]);


