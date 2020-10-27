<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
require('/home/matt00/Downloads/git/allWeb/ServerClient.php');



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
	
	$ret = getpos($pk, $prk);
	
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





<html>

<head>

<title> YahooFin Portal </title>

<link rel="stylesheet" href="stylesheet0.css">

</head>


<body>

<h1> 
<?php echo $header; ?>
</h1>


<!--
 Need to make this top text box larger for the error message, probably best to do it in CSS

these were for testing
<input type="text" value=""> 
<input type="text" value="">
-->

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

<p> Please peruse our vast array of financial information at your leisure.</p>

<img src="<?php echo $pic; ?>">



</body>


</html>

