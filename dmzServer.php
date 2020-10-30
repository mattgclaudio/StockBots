#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');




function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);

  $pubkey = $request['pubkey'];
  $privkey = $request['privkey'];

  $op = "error in processing";

  switch ($request['action']) {

		# this was my hacky way of getting php to pass the variables
	# correctly when its moved to a shell command (python)
	case "cash": 
		
		$start = '/home/matt/git/rabbitMQMerged/scripts/script1.py ';
		
		$start .= $pubkey . ' ' . $privkey;
		
		# this line will escape the string we just made and execute 
		# the command in a host shell.
		$op = shell_exec(escapeshellcmd($start));
		
		break;

	case "pos":
		
		$start = '/home/matt/git/rabbitMQMerged/scripts/script2.py ';
		
		$start .= $pubkey . ' ' . $privkey;
		
		$op = shell_exec(escapeshellcmd($start));
		
		break;
	
	case "order":
		
		# get the stock ticker symbol and number to purchase 
		# from request array
		
		$sym = $request['sym'];
		$num = $request['num'];

		# start shell command
		$str = '/home/matt/git/rabbitMQMerged/scripts/script5.py ';
		
		# add all arguments
		$str .= $pubkey . ' ' . $privkey . ' ' . $sym . ' ' . $num;
		
		# escape and execute the command, store results in shellres
		# for this command if it runs fine there should be no 
		# output
		
		$shellres = shell_exec(escapeshellcmd($str));
		
		# if there is no output, say as much, else return the error
		# this is a ternary operator FYI
		$op = empty($shellres) ? "Order placed" : $shellres;

		break;

	case "bot":

		$botsym = $request['botsym'];
		
                $str = '/home/matt/git/rabbitMQMerged/dmz_bot_1.py ';
		
		# add symbol name
		$str .= $botsym;
		
		$shellres = shell_exec(escapeshellcmd($str));
		if (!$shellres) {

		$op = 'Error, no data found for that stock symbol';
		break;
		
		}

		else {
		$op = "Here is the prediction chart for " . $botsym;
		break;

		}

		

	default:
		$emsg = "no valid action for user account given";
		$op = "error in processing";
		break;

}


  return array('message' => $op);
}

$server = new rabbitMQServer("alpaca.ini","dmzServer");

echo "DMZ Server BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "DMZ Server END".PHP_EOL;
exit();
?>
