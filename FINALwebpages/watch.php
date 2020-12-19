<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
require('/home/matt00/git/WebFrontEnd/ServerClient.php');


$header = "Welcome To Our Strike Price Notification Page";
$block = " Enter a new stock to watch or see if any have struck yet.";

# add stock and price to ini file
if (isset($_POST['add'])) {

	$callback = newWatchedStock($_SESSION['uid'], $_POST['watch_stock'],
		$_POST['watch_price']);

        $block = $callback['message'];	
}

# check the stocks already in the ini file
if (isset($_POST['watch'])) {

        $callback = checkWatchedStocks($_SESSION['uid']);

        $block = $callback['message'];
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
      			<li><a href="bots.php">   Bots   </a></li>
      			<li><a href="check.php">   Account   </a></li>
      			<li><a href="order.php">Place Order</a></li>
    		</ul>
	</div>
</nav>


<div class="jumbotron-fluid p-3 my-3 bg-dark text-white"> 

		<?php echo $header; ?>
</div>



 <div class="container-fluid p-3 my-2 border">

   <div class="row">

	<div class="col-md-4">

	   <label>  Select New Stock To Watch</label>
		
	   <form method="post" action="">
		
 		<input type="hidden" name="add">
		
		<input type="text" name="watch_stock" placeholder="Ticker">
		
		<input type="number" name="watch_price" placeholder="Int Price">
		
		<button type="submit"> Watch New Stock </button> 
		
	    </form>

	</div>   <!--end watch new stock column-->  

   </div> <!--end row-->

<br><br><br>


   <div class="row">

        <div class="col-md-4">

	    <form method="post" action="">

                <input type="hidden" name="watch">

                <button type="submit"> Check Watched Stocks </button>

            </form>

	</div>

   </div>



   <div class="row">
		
	<div class="col-md-4">
	
		<textarea id="response" name="response" rows="10" cols="40"><?php echo $block;?></textarea>
		
	</div>   <!--end textarea column-->
	
    </div>   <!--end textarea row-->



</div> <!--end full container-->

</body>


</html>

