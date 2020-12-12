<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');



function packandship($versionNum) {
	# pass in a name for this version

	# eventual filename
	$fullname = 'webPackage'.$versionNum.'.tar.gz';

	# create & run shell command to compress needed directories
	$compress = 'tar -czf '.$fullname.' /var/www/html/stockTracker /home/matt00/git/rabbitMQMerged /etc/apache2/';
	shell_exec(escapeshellcmd($compress));

	# create & run shell command to send package to Deployment box
	$deliver = 'scp '.$fullname.
		' matt@192.168.1.182:/home/matt/git/rabbitMQMerged/packages';
	shell_exec(escapeshellcmd($deliver));

	# create & run shell command to remove package from local machine 
	$tidy = 'rm '.$fullname;
	shell_exec(escapeshellcmd($tidy));
}


function versionupdate($versStr) {

	packandship($versStr);
	
	sleep(5);
	
	$client = new rabbitMQClient("Deployment.ini", "deploymentServer");

        $req = array();
	$req['type'] = 'index';
	$req['version'] = $versStr;

        return $client->send_request($req);

}


versionupdate('background');


