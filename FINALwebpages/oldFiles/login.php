<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
require('/home/matt00/git/WebFrontEnd/ServerClient.php');

# Var for what post returned
$p = $_POST;

if (isset($p['uname'])) {
	
	$lucky = dologin($p['uname'], $p['pword']);
	
	$retarr = $lucky['msg'];
	$uid = $retarr['uid'];

	if (!$uid){
		
        	$_SESSION['msg'] = $lucky['msg'];
		header('Location: http://127.0.0.1/errpage.php');
			}

	else {
	
		$_SESSION['uid'] = $uid;
		header('Location: http://127.0.0.1/action.php');
      	
	}
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<title> YahooFin Portal Login Vehicle </title>

</head>


<body>

	<div class="jumbotron-fluid p-3 my-3 bg-dark text-white">
                <h1>Click the button to move to the action page</h1>
        </div>


	<div class="container-fluid p-3 m-6 border">
		<form method="post" action="action.php">
		<button type="submit"> Move to Action Page </button>
		</form>
	</div>
</body>


</html>

