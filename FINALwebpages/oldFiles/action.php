<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
require('/home/matt00/git/WebFrontEnd/ServerClient.php');

$post = $_POST;

$header = "Welcome to Your Action Page";

if (isset($post['chkcash'])) {
	$ret = getcash($_SESSION['uid']);
	$cash = $ret['message'];

	$transferPhoto = $ret['pic'];
	
	$header = "Cash Balance";
}


if (isset($post['pos'])) {
	
	$retstr = getpos($_SESSION['uid']);
	
	$posarr = preg_split("/,/", $retstr['message']);

	$header = "Active Positions";

}

if (isset($post['order'])) {
	
	$s = $post['sym'];
	$n = $post['num'];

	$ret = putorder($_SESSION['uid'], $s, $n);

	$header = $ret['message'];
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


<title> Alpaca API Portal </title>

</head>


<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  
	<div class="container-fluid">
    		<div class="navbar-header">
      			<a class="navbar-brand" href="#">Alpaca Trading API Portal</a>
    		</div>
    
		<ul class="nav navbar-nav">
     			 <li class="active"><a href="index.html">Home</a></li>
      			<li><a href="bots.php">Bot Page</a></li>
      			<li><a href="watch.php">Strike Price Page</a></li>
      			<li><a href="#">Page 3</a></li>
    		</ul>
	</div>
</nav>


	<div class="jumbotron-fluid p-3 my-3 bg-dark text-white"> 
		<?php echo $header; ?>
	</div>



 <div class="container-fluid p-3 my-2 border">
		

	<div class="row">

                <div class="col-md-4 p-md-3">

		<label>Get Cash Balance </label>
		
		 <input type="text" size="100"placeholder="Your Cash Balance will appear here" value="<?php if (!empty($cash)) { echo $cash; } ?>">
		
		<form method="post" action="">
		
		<input type="hidden" name="chkcash">
		
		<button type="submit"> Submit </button>
		
		</form>

		</div>
	</div>


	<div class="row">

                <div class="col-md-4">

		<label> See Current Positions </label>
		
		<input type="text" id="pos" placeholder="Your active positions will appear here." size="100" value="<?php if (!empty($posarr)) { foreach ($posarr as $k) {echo $k;} } ?>">
		
		<form method="post" action="">
		
		<input type="hidden" name="pos">
		
		<button type="submit"> Submit </button>
		
		</form>
		
		 </div>

	</div>

	<div class="row">

                <div class="col-md-4">

		<label>  Enter stock symbol all caps, quantity </label>

		<form method="post" action="">
		
		<input type="hidden" name="order">
		
		<input name="sym" placeholder="Symbol, All Caps">
		
		<input name="num" type="number">
		
		<button type="submit"> Submit </button>
		
		</form>
	
		</div>

	 </div>


</div> <!--end full container-->

</body>


</html>

