<?php

function getPackage($id) {
	
	$ent = 'scp matt@192.168.1.183:/home/matt/git/packages/' .
		$id .'.tar.gz /home/matt00/git/packages';
	shell_exec(escapeshellcmd($ent));

}

getPackage($argv[1]);


