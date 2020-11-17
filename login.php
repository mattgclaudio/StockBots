<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
<<<<<<< HEAD
require('/home/sam/git/webserverVM/rabbitMQMerged/ServerClient.php');


=======
require('/home/matt00/Downloads/git/rabbitMQMerged/ServerClient.php');
>>>>>>> a5959c18fac39b1343a3ef3617f6b51af23868ca

# Var for what post returned
$p = $_POST;

if (isset($p['uname'])) {
	
	$un = $p['uname'];
	$pw = $p['pword'];

	$lucky = dologin($un, $pw);

	$_SESSION['pubkey'] = $lucky['pubkey'];
	$_SESSION['privkey'] = $lucky['privkey'];
	
	$header = $lucky['msg'];
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
		<button type="submit"> Perform Account Transactions </button>
		</form>
	</div>
</body>


</html>

