<?php
/* Database credentials. Assuming you are running MySQL
 * Server with defauly setting (user 'root' with no password) */

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'rabbit');
define('DB_PASSWORD', 'rabbitMQ2020!');
define('DB_NAME', 'login_db');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
	die("ERROR: Could not connect, " . mysqli_connect_error());
}

?>
