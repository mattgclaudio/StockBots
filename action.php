<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
require('/home/matt00/Downloads/git/rabbitMQMerged/ServerClient.php');



# Var for what post returned
$post = $_POST;

$pk = $_SESSION['pubkey'];
$prk = $_SESSION['privkey'];



if (isset($post['chkcash'])) {
	$ret = getcash($pk, $prk);
	$displaybar = $ret['message'];
	$header = "Cash Balance";
}


if (isset($post['pos'])) {
	
	$retstr = getpos($pk, $prk);
	
	$positions = preg_split(" /,/", $retstr);
	
	$displaybar = $ret['message'];
	$header = "Active Positions";

}

if (isset($post['order'])) {
	
	$s = $post['sym'];
	$n = $post['num'];

	$ret = putorder($pk, $prk, $s, $n);

	$displaybar = $ret['message'];
	$header = "Order Placed";
}




if (isset($post['bot'])) {

        $ret5 = callBot();
	$pic = base64_decode($ret5['message']);
        $displaybar = "Bot Performance";
	$header = "Bot has run data";

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


<title> YahooFin Portal </title>

</head>


<body>

	<div class="jumbotron-fluid p-3 my-3 bg-dark text-white"> 
		<?php echo $header; ?>
	</div>

	 <div class="container-fluid p-3 m-6 border">
	
		<form method="post" action="">
		<input type="hidden" name="chkcash">
		<button type="submit"> Check Cash Balance </button>
		</form>

		<form method="post" action="">
		<input type="hidden" name="pos">
		<button type="submit"> Get Active Positions </button>
		</form>

		<form method="post" action="">
		<input type="hidden" name="order">
		<input name="sym">
		<input name="num" type="number">
		<button type="submit"> Place Order </button>
		</form>

		<form method="post" action="">
		<input type="hidden" name="bot">
		<button type="submit"> Bot Graph </button>
		</form>

		<input type="text" value="<?php echo $displaybar; ?>">
		 
		 <div class="jumbotron-fluid p-3 my-3"> 
			<?php foreach ($positions as $j) echo "$j \n"; ?>
		</div>
		 

	</div>

	<img src="http://192.168.1.177/photoHost/test_plot.png" class="float-left">



</body>


</html>

