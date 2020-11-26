<?php


function pingdb() {
# PHP connetion to DB
    $mysqli = new mysqli('localhost', 'matt', 'toor', 'vault');

    # If DB has errored out:
    if ($mysqli->connect_errno) {
	    # timestamped error message for log
	    $err0 = "Error from DB: failed to connect to DB      "
		    . date("H:i:s") . "\n";
	    # open log file
	    $handle = fopen("/home/matt/git/UserDatabase/Backup/dbconn.log",
		    "a+") or die("failed to open var dbconnlog.log");
	    # write error message
	    fwrite($handle, $err0);
	     # close file conn
	    fclose($handle);
	    # call the script to send the latest db clone 
	    $ship = '/home/matt/git/UserDatabase/Backup/shiptable.sh';
	    shell_exec(escapeshellcmd($ship));
   			 } # end connection failed

    else { 
	    # call the script to run mysqldump and overwrite the previous dump
	    $save = '/home/matt/git/UserDatabase/Backup/dump.sh';
	    shell_exec(escapeshellcmd($save));
	    # open log file	
	    $dcl = fopen("/home/matt/git/UserDatabase/Backup/dbconn.log",
		    "a+") or die("could not open file");
	    # successful connection message
	    $reg = "DB connection achieved.   ".date("H:i:s")."\n";
	    #write to file
	    fwrite($dcl, $reg);
	    #close file
	    fclose($dcl);
	    #  comment out on production
	    echo "User DB Running". PHP_EOL;
    } # end successful connection 
} # end pingdb()


pingdb();
