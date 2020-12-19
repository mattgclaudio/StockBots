<?php
session_start();
#This line has to be run before anything else for the session vars to work

# Var for what post returned





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

<title> <?php echo $_SESSION['msg']; ?> </title>

</head>


<body>

	<div class="jumbotron-fluid p-3 my-3 bg-dark text-white">
		<h1>Unable to Log In</h1>
		
        </div>


	<div class="container-fluid p-3 m-6 border">
		<form method="post" action="index.html">
		<button type="submit"> Return to Login Page </button>
		</form>
	</div>
</body>


</html>

