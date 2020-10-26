<?php
session_start();
#This line has to be run before anything else for the session vars to work

# this line will have to be changed based on where the RabbitCLIENT file is in # relation to the login.php
require('/home/matt00/Downloads/git/allWeb/ServerClient.php');



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

<form method="post" action="action.php" >
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

