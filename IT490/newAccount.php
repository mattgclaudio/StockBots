<!DOCTYPE html>
<body>

<html>
<head>
	<title>Welcome</title>
	<link type ="text/css" rel="stylesheet" href="loginStyle.css">
</head>

<?php

require_once('connect.php');

function updateLog($errmsg) {
	# with this a+ opening mode we APPEND to this existing logbook
	$newentry = fopen("/home/matt/logbook.txt", "a+");
	fwrite($newentry, $errmsg ."/n");
	fclose($newentry);
}

	if(isset($_POST['reg_user'])){

	$userName = $_POST['uname'];
	$passWord = $_POST['pword'];
	$confirmPass = $_POST['confirmpw'];
	$email = $_POST['email'];

	if($passWord != $confirmPass){
		updatelog('Passwords do not match.');
		echo 'Passwords do not match.';
	}
	else{
	
		$pass = $passWord;
		$sql = "INSERT INTO accounts (username, password, email) VALUES('$userName', '$passWord', '$email')";
		$result = mysqli_query($con,$sql);

	if($result){
		
		echo 'You have succesfully created a new account.';
	}
	else {
		updateLog('Failed to create new account. Please check your inputs.');
		echo 'Failed to create new account. Please check your inputs.';
	}
	}
}

?>

	<div class="loginbox">
	
	<h1>Welcome</h1>
	
	</div>

	
</body>
</html>
