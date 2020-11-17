<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');



function packandship($versionNum) {
	
	# we could pass a time or version number as a parameter and update the 	       # package name that way, or differentiate them some other way,
	# but we should probably not just have them all named the same.
	# either way here we compress the contents of the webfacing 
	# directory and the rabbit directory that holds the client
	# functions and such.

	# here
	$fullname = 'webPackage'.$versionNum.'.tar.gz';

	# create & run shell command to compress needed directories
	$compress = 'tar -czf '.$fullname.' /var/www/html/stockTracker /home/matt00/Downloads/git/rabbitMQMerged';
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


