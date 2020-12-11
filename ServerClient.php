<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');



function dologin($a, $b) {
	
	$client = new rabbitMQClient("rabbit.ini","testServer");

	$request = array();

	$request['type'] = "login";
	$request['username'] = $a;
	$request['password'] = $b;

	return $client->send_request($request);
}

#these next two functions could probably be combined, but i have been working
#and testing incrementally so this is where i'm at rn.

function getcash ($userid) {

	$client = new rabbitMQClient("rabbit.ini", "testServer");

	$req = array();
	$req['type'] = "dmz";
	$req['uid'] = $userid;
	$req['action'] = "cash";

	return $client->send_request($req);
}



function getpos($userid) {

	$client = new rabbitMQClient("rabbit.ini", "testServer");

        $req = array();
        $req['type'] = "dmz";
        $req['uid'] = $userid;
        $req['action'] = "pos";

        return $client->send_request($req);

}



function putorder($userid, $symbol, $number) {

	$client = new rabbitMQClient("rabbit.ini", "testServer");

        $req = array();
        $req['type'] = "dmz";
        $req['uid'] = $userid;
	$req['sym'] = $symbol;
	$req['num'] = $number;
        $req['action'] = "order";

        return $client->send_request($req);
}



function callBot0($uid, $symbol) {

	$client = new rabbitMQClient("rabbit.ini", "testServer");

        $req = array();
	$req['type'] = "dmz";
	$req['uid'] = $uid;
	$req['action'] = "bot0";
	$req['botsym'] = $symbol;

        return $client->send_request($req);
}

function callBot1($uid, $symbol) {

        $client = new rabbitMQClient("rabbit.ini", "testServer");

        $req = array();
        $req['type'] = "dmz";
        $req['uid'] = $uid;
        $req['action'] = "bot1";
        $req['botsym'] = $symbol;

        return $client->send_request($req);
}


function callBot2($uid, $symbol) {

        $client = new rabbitMQClient("rabbit.ini", "testServer");

        $req = array();
        $req['type'] = "dmz";
        $req['uid'] = $uid;
        $req['action'] = "bot2";
        $req['botsym'] = $symbol;

        return $client->send_request($req);
}


function newWatchedStock($uid, $new_stock, $new_price) {
	
	$client = new rabbitMQClient("rabbit.ini", "testServer");

        $req = array();
        $req['type'] = "dmz";
        $req['uid'] = $uid;
	$req['action'] = "add";
	$req['symbol'] = $new_stock;
	$req['price'] = $new_price;

	return $client->send_request($req);

}

function checkWatchedStocks($uid) {

	$client = new rabbitMQClient("rabbit.ini", "testServer");

        $req = array();
        $req['type'] = "dmz";
        $req['uid'] = $uid;
	$req['action'] = "watch";

	return $client->send_request($req);


}



