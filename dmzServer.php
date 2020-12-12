#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function updateLog($errmsg) {
	# with this a+ opening mode we APPEND to this existing logbook
	$newentry = fopen("/home/matt/logbook.txt", "a+");
	fwrite($newentry, $errmsg ."/n");
	fclose($newentry);

		}


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

  # pull the customers keys from the ini file based on their uid
  $temp = getkeys($request['uid']);

  $pubkey = $temp['p1'];
  $privkey = $temp['p2'];

  if (!$pubkey && !$privkey) {
  	
	  return array('message' => "No keys found in ini file");
  }


  switch ($request['action']) {

  
 	# get current cash balance of our testing paper account 
  	case "cash": 
		$start = '/home/matt/git/rabbitMQMerged/scripts/script1.py '
		 . $pubkey . ' ' . $privkey;
		$op = shell_exec(escapeshellcmd($start));
		$photo_base64 = base64_encode(file_get_contents('/home/matt/git/rabbitMQMerged/images/mustang.png'));
		break;

		# return active positions array
	case "pos":
		$start = '/home/matt/git/rabbitMQMerged/scripts/script2.py ';
		$start .= $pubkey . ' ' . $privkey;
		$op = shell_exec(escapeshellcmd($start));
		break;

	# pass vars and execute order request through API
	case "order":
		$sym = $request['sym'];
		$num = $request['num'];
		$str = '/home/matt/git/rabbitMQMerged/scripts/script5.py ';
		$str .= $pubkey . ' ' . $privkey . ' ' . $sym . ' ' . $num;		       $shellres = shell_exec(escapeshellcmd($str));
		$op = empty($shellres) ? "Order placed" : $shellres;
		break;

	# send ticket to bot0 for processing, send back photo and conf


	case "bot0":
		$botsym = $request['botsym'];
		$str = '/home/matt/git/rabbitMQMerged/dmz_bot_0.py ';
		$str .=	$botsym;

		$shellres = shell_exec(escapeshellcmd($str));
		
		$photo_base64 =
			base64_encode(file_get_contents('/home/matt/git/rabbitMQMerged/tempGraph0.png'));

		$goodmsg = "Here is the prediction chart for " . $botsym;
		$op = ($goodmsg); 
		break;



	# send stock ticker to bot1 script for processing, send back photo
		# and confirmation message	
	
	case "bot1":
		$botsym = $request['botsym'];
		$str = '/home/matt/git/rabbitMQMerged/dmz_bot_1.py ';
		$str .=	$botsym;

		$shellres = shell_exec(escapeshellcmd($str));
		
		$photo_base64 =
			base64_encode(file_get_contents('/home/matt/git/rabbitMQMerged/tempGraph1.png'));

		$goodmsg = "Here is the prediction chart for " . $botsym;
		$op = ($goodmsg); 
		break;


	# send stock ticker to bot2 script for processing, send back photo
		# and confirmation message
	
	case "bot2":
		$botsym = $request['botsym'];
		$str = '/home/matt/git/rabbitMQMerged/dmz_bot_2.py ';
		$str .=	$botsym;

		$shellres = shell_exec(escapeshellcmd($str));
		
		$photo_base64 =
			base64_encode(file_get_contents('/home/matt/git/rabbitMQMerged/tempGraph2.png'));

		$goodmsg = "Here is the prediction chart for " . $botsym;
		$op = ($goodmsg); 
		break;


	case "add":
		
		$newsym = $request['symbol'];
		$newprice = $request['price'];

		$str = '/home/matt/git/rabbitMQMerged/scripts/addStock.py '
			. $request['uid']. ' ' . $newsym . ' ' . $newprice;

		$shellres = shell_exec(escapeshellcmd($str));
		$op = $shellres;
		break;


	case "watch":
		
		$uid = $request['uid'];
		
		$str = '/home/matt/git/rabbitMQMerged/scripts/watchStock.py ' 
			. $uid;

		$shellres = shell_exec(escapeshellcmd($str));
                $op = $shellres;
                break;


	default:
		$emsg = "no valid action for user account given";
		updateLog($emsg);
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

