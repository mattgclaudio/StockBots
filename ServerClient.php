<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


##
# So this file serves as a storage space for the individual functions the
# website uses to enable the user to log in, perform actions on the 
# DMZ API, etc. 
#
# This amounts to specifying in the request array the function code
# being performed, taking the necessary  data in variables and adding 
# them into the request array as well, sending the request and 
# passing back the response for the user to see. 
#
# All of the requests are  packaged in this manner and passed on by
# the rabbitMQ Broker service with a switch case for the swrequest['type']
# var to determine where it's going, passing the whole request along to the
# intended recipient and then passing it's response back to the sender. 

function dologin($a, $b) {
	$client = new rabbitMQClient("rabbit.ini","testServer");
	$request = [
		"type" => "login",
		"username" => $a,
		"password" => $b,
		];
	return $client->send_request($request);
}



function getcash ($userid) {
	$client = new rabbitMQClient("rabbit.ini", "testServer");
	$req = [
		"type" => "dmz",
		"uid" => $userid,
		"action" => "cash",
		];
	return $client->send_request($req);
}



function getpos($userid) {
	$client = new rabbitMQClient("rabbit.ini", "testServer");
        $req = [
		"type" => "dmz",
		"uid" => $userid,
		"action" => "pos",
		];
        return $client->send_request($req);

}



function putorder($userid, $symbol, $number) {

	$client = new rabbitMQClient("rabbit.ini", "testServer");
	# just in case the user entered a lowercase ticker symbol
	$symbol = strtoupper($symbol);
        $req = [
		"type" => "dmz",
		"uid" => $userid,
		"sym" => $symbol,
		"num" => $number,
		"action" => "order",
		];
	
        return $client->send_request($req);
}



function callBot0($uid, $symbol) {
	$client = new rabbitMQClient("rabbit.ini", "testServer");
	$symbol = strtoupper($symbol);
        $req = [
		"type" => "dmz",
		"uid" => $uid,
		"action" => "bot0",
		"botsym" => $symbol,
		];
	
        return $client->send_request($req);
}

function callBot1($uid, $symbol) {

        $client = new rabbitMQClient("rabbit.ini", "testServer");
	$symbol = strtoupper($symbol);
	$req = [
		"type" => "dmz",
		"uid" => $uid,
		"action" => "bot1",
		"botsym" => $symbol,
		];
   
        return $client->send_request($req);
}


function callBot2($uid, $symbol) {

        $client = new rabbitMQClient("rabbit.ini", "testServer");
	$symbol = strtoupper($symbol);
	$req = [
		"type" => "dmz",
		"uid" => $uid,
		"action" => "bot2",
		"botsym" => $symbol,
		];
	
        return $client->send_request($req);
}


function newWatchedStock($uid, $new_stock, $new_price) {
	
	$client = new rabbitMQClient("rabbit.ini", "testServer");
`	$new_stock = strtoupper($new_stock);
	
        $req = [
		"type" => "dmz",
		"uid" => $uid,
		"action" => "add",
		"symbol" => $new_stock,
		"price" => $new_price,
		];

	return $client->send_request($req);

}

function checkWatchedStocks($uid) {

	$client = new rabbitMQClient("rabbit.ini", "testServer");

        $req = array();
        $req['type'] = "dmz";
        $req['uid'] = $uid;
	$req['action'] = "watch";

	return $client->send_request($req);


}


function pingbackupdb() {
	
	$clientB = new rabbitMQClient("rabbit.ini", "failServer");

        $reqB = [
        	"type" => "ref",
        	"refid" => "QA",
		];

	try {
		$clientB->send_request($reqB);
		return true;
	}
	catch (Exception $e) {
		return false;
	}
}




function pingrabbitdb() {
	# main rabbitDB Server request array
	$clientA = new rabbitMQClient("rabbit.ini", "testServer");
        $reqA = [
        "type" => "ref",
	"refid" => "QA",];	
	try {
		# try and ping the main server
		$clientA->send_request($reqA);
		return true;
		
	}
	catch(Exception $e) { # if the main server ping failed
		
		# get the failover flag status from the ini file FLAG
		# var.
		$ini = parse_ini_file('rabbit.ini', true);
		$backupflag =  $ini["failServer"]["FLAG"];
		
		# if the failover is up and not already set to alive
		if (pingbackupdb() &&  $backupflag != 1) {  
		
			# run the script to point the web php pages
			# at the failOver RabbitDB for auth/DMZ
			# access. 
			
			$cmd = '/home/matt00/git/WebFrontEnd/replaceINI.sh';
			shell_exec($cmd);
			return 9;
		
		} 

		# if the backup is turned on and still alive, we good
		elseif (pingbackupdb()) {

			return 0;
		
		} 

		else {  # otherwise, nothing is up and we have a problem. 
			return 1;
		
		
		}

	} 	
} # end pingrabbitdb

function pingwatch() {
	# while we have an active internet connection
	while (connection_status() == 0) {
		# see who is up or down
		$monitor_code = pingrabbitdb();
		
		switch ($monitor_code) {
		
		case 0:
			# one or the other is up, no worries
                        return 0;
                        break;
		case 9:
			#  backup just kicked in, refresh the page
			header("Refresh:0");
			return 0;
                        break;
		case 1:
			# nothing is up, move to error page
                        header('Location: https://www.stocktracker.com/errpage.php');
                        break;
                }

		# wait 5 seconds
                sleep(10);
     
	}

}


