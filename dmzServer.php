#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function getkeys($userid) {

	# pass the userid from the user database, get the keys listed for them.
        $ret = array();
        $iniarr = parse_ini_file("keyring.ini", true);

        # if they have a public and private key 
        # listed under their uid in the keyring.txt file
        if (($ret['p1'] = $iniarr[$userid]["public"]) &&
                ($ret['p2'] = $iniarr[$userid]["private"])) {

                return $ret;
        }

        else {

                return $ret['p1'] = NULL && $ret['p2'] = NULL;
        }

}







function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);

  $temp = getkeys($request['uid']);

  $pubkey = $temp['p1'];
  $privkey = $temp['p2'];

  if (!$pubkey && !$privkey) {
  	
	  return array('message' => "No keys found in ini file");
  }


  switch ($request['action']) {

		# this was my hacky way of getting php to pass the variables
	# correctly when its moved to a shell command (python)
  
  
  	case "cash": 
		$start = '/home/matt/git/rabbitMQMerged/scripts/script1.py '
		 . $pubkey . ' ' . $privkey;
		$op = shell_exec(escapeshellcmd($start));
		$photo_base64 = base64_encode(file_get_contents('/home/matt/git/rabbitMQMerged/images/mustang.png'));
		break;

	case "pos":
		$start = '/home/matt/git/rabbitMQMerged/scripts/script2.py ';
		$start .= $pubkey . ' ' . $privkey;
		$op = shell_exec(escapeshellcmd($start));
		break;
	
	case "order":
		$sym = $request['sym'];
		$num = $request['num'];
		$str = '/home/matt/git/rabbitMQMerged/scripts/script5.py ';
		$str .= $pubkey . ' ' . $privkey . ' ' . $sym . ' ' . $num;		       $shellres = shell_exec(escapeshellcmd($str));
		$op = empty($shellres) ? "Order placed" : $shellres;
		break;

	case "bot":
		$botsym = $request['botsym'];
                $str = '/home/matt/git/rabbitMQMerged/dmz_bot_1.py ' . $botsym;
		$shellres = shell_exec(escapeshellcmd($str));
		if (!$shellres) {
		$op = 'Error, no data found for that stock symbol';
		break;
		}
		else {
		$op = "Here is the prediction chart for " . $botsym;
		

		$photo_base64 = base64_encode(file_get_contents('/home/matt/git/rabbitMQMerged/images/tempGraph.png'));
		break;
		}

	default:
		$emsg = "no valid action for user account given";
		$op = "error in processing";
		break;

		}
	

  	return array('message' => $op, 'pic' => $photo_base64 ?? Null);
	}

$server = new rabbitMQServer("alpaca.ini","dmzServer");

echo "DMZ Server BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "DMZ Server END".PHP_EOL;
exit();
?>

