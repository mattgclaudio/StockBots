<?php
require_once('/home/matt00/git/WebFrontEnd/path.inc');
require_once('/home/matt00/git/WebFrontEnd/get_host_info.inc');
require_once('/home/matt00/git/WebFrontEnd/rabbitMQLib.inc');
# accessory function for the one below
# hits the backup DB with a ref  call, just to see if its there. 
# if the call goes through the function is valid, if not its false

function logPing($var) {
	$lf = fopen("/home/matt00/git/WebFrontEnd/weblog.txt", "a+");
	fwrite($lf, $var);
	fwrite($lf, "\n");
	fclose($lf);
	return;
}

# pings backup database rabbit exchange, returns false is no hit. 
function pingbackupdb() {

      $clientB = new rabbitMQClient("/home/matt00/git/WebFrontEnd/rabbit.ini", 
	"failServer");

        $reqB = [
        	"type" => "ref",
        	"refid" => "QA",
		];
			
	if  ($clientB->send_request($reqB)) {
		logPing("backup hit   " . date("H:i:s"));
		return true;		
	} 

	else {	
		logPing("backup not hit   " . date("H:i:s"));
		return false;	
	}
} # end ping backup


# first ping the main db, if thats not working see if the backup is up and 
# has not been set to active, if its set to active dont do anything, otherwise
# there is a major error. 

function pingrabbitdb() {
	
      $clientA = new rabbitMQClient("/home/matt00/git/WebFrontEnd/rabbit.ini",
	      "testServer");

        $reqA = [
        "type" => "ref",
	"refid" => "QA",
	];

	# get the failover flag status
	$ini = parse_ini_file('/home/matt00/git/WebFrontEnd/rabbit.ini', true);
        $backupflag =  $ini["failServer"]["FLAG"];
	
	logPing('inside pingrabbitdb script');
	# ping main DB
	if ($clientA->send_request($reqA)) {
		logPing("Main hit   " . date("H:i:s"));
		
		if ($ini["testServer"]["FLAG"] == -1) {  # if the server WAS
		  #  down, reset the files. 	
		$cmd = '/home/matt00/git/WebFrontEnd/putBackINI.sh';
		shell_exec($cmd);
		}

		return;	# otherwise just return
	}

	# if main is down...
	elseif (pingbackupdb()) {  #  if the backup is online
		# if backup online, and no change yet.
	
		if ($backupflag !== 1) {  # run script to change files
		logPing("main down, switching to backup" . date("H:i:s"));
		shell_exec('/home/matt00/git/WebFrontEnd/replaceINI.sh');
		return;
		}
		else {  # if the backup is online and has been switched to
			logPing("backup hit and switched to    " . 
				date("H:i:s"));
			return;
		}
	} 

	else {   	# if neither are up
		logPing("neither are up" . date("H:i:s"));
		return;
       	}
	
	
} 



pingrabbitdb();
