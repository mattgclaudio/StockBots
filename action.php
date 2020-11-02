<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
require('/home/sam/git/webserverVM/rabbitMQMerged/ServerClient.php');



# Var for what post returned
$post = $_POST;

$pk = $_SESSION['pubkey'];
$prk = $_SESSION['privkey'];



if (isset($post['chkcash'])) {
	$ret = getcash($pk, $prk);
	$displayBar = $ret['message'];
	$header = "Cash Balance";
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

<form method="post" action="" >
<input type="hidden" name="chkcash">
<button type="submit"> Check Cash Balance </button>
</form>

<form method="post">
<button type="submit"> Get Active Positions </button>
</form>

<input type="text" value="<?php echo $displayBar; ?>"

<p> Please peruse our vast array of financial information at your leisure.</p>



</body>


</html>

