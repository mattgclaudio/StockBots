<?php

$mysqli = new mysqli('localhost', 'matt', 'toor', 'vault');

if ($mysqli->connect_errno) {
	echo 'no php connection to DB';
}

else {

	echo 'connection achieved';
}


