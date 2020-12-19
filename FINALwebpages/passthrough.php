<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
require('/home/matt00/git/WebFrontEnd/ServerClient.php');

# Var for what post returned
$p = $_POST;

if (isset($p['uname'])) {
	
	$lucky = dologin($p['uname'], $p['pword']);
	
	$uid = $lucky['uid'];

	$_SESSION['uid'] = $uid;

	if ($uid){
		
		header('Location: https://www.stocktracker.com/check.php');
		exit;
		}
		
		
	else {
	
		$_SESSION['msg'] = $lucky['msg'];
		header('Location: https://www.stocktracker.com/errpage.php');
		exit;
	}

}


?>

