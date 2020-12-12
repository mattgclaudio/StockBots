<?php

function getkeys($userid) {
	
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

	$jacob = getkeys(1);

	$p = $jacob['p1'];
	$r = $jacob['p2'];


   	$start = '/home/matt/git/rabbitMQMerged/scripts/script1.py ' .
		$p .
		' ' .
	       	$r;
	
	echo shell_exec(escapeshellcmd($start));

