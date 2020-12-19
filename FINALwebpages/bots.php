<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
require('/home/matt00/git/WebFrontEnd/ServerClient.php');

$post = $_POST;

$header = "Welcome To Our Trading Algorithm Bot Page";


if (isset($post['bot0'])) {

	$botsym = $post['botsym0'];

        $botmsg = callBot0($_SESSION['uid'], $botsym);
	
	$header = $botmsg['message'];
	$transferPhoto = $botmsg['pic'];

}


if (isset($post['bot1'])) {

	$botsym = $post['botsym1'];

        $bot1msg = callBot1($_SESSION['uid'], $botsym);
	
	$header = $bot1msg['message'];
	$transferPhoto = $bot1msg['pic'];

}


if (isset($post['bot2'])) {

	$botsym = $post['botsym2'];

        $bot2msg = callBot2($_SESSION['uid'], $botsym);
	
	$header = $bot2msg['message'];
	$transferPhoto = $bot2msg['pic'];

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
     			 <li class="active"><a href="index.html">  Home  </a></li>
      			<li><a href="bots.php">  Bot     </a></li>
      			<li><a href="watch.php">  Strike Price    </a></li>
			<li><a href="order.php">Place Order</a></li>
			<li><a href="check.php">Account </a></li>

    		</ul>
	</div>
</nav>


<div class="jumbotron-fluid p-3 my-3 bg-dark text-white"> 

		<?php echo $header; ?>
</div>



 <div class="container-fluid p-3 my-2 border">

   <div class="row">

	<div class="col-md-4">

	   <label>  See Bot #0's Predictions.</label>
		
	   <form method="post" action="">
		
 		<input type="hidden" name="bot0">
		
		<input type="text" name="botsym0" placeholder="Stock Symbol">
		
		<button type="submit"> Bot Graph </button> 
		
	    </form>

	</div>   <!--end bot0 column-->  

   </div> <!--end row-->

  
  
   <div class="row">

	<div class="col-md-4">

	   <label>  See Bot #1's Predictions.</label>
		
	   <form method="post" action="">
		
 		<input type="hidden" name="bot1">
		
		<input type="text" name="botsym1" placeholder="Stock Symbol">
		
		<button type="submit"> Bot Graph </button> 
		
	    </form>

	</div>   <!--end bot1 column-->  

   </div> <!--end  bot1 row-->


   <div class="row">

	<div class="col-md-4">

	   <label>  See Bot #2's Predictions.</label>
		
	   <form method="post" action="">
		
 		<input type="hidden" name="bot2">
		
		<input type="text" name="botsym2" placeholder="Stock Symbol">
		
		<button type="submit"> Bot Graph </button> 
		
	    </form>

	</div>   <!--end bot2 column-->  

   </div> <!--end  bot2 row-->



	<div class="row">
		
		<div class="col-md-4">
	
			<img src="<?php echo "data:image/png;base64," 
				. $transferPhoto; ?>" alt="Prediction Graph Will Populate Here"/>
		
		</div>   <!--end image column-->
	
	</div>   <!--end photo row-->

</div> <!--end full container-->

</body>


</html>

