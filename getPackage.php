<?php

function getPackage($id) {
	
	$ent = 'scp sam@10.192.226.24:/home/sam/git/packages/webPackage'
		.$id
		.'.tar.gz /home/matt00/git/packages';
	shell_exec(escapeshellcmd($ent));

}

getPackage($argv[1]);


