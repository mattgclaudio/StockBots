<?php


function pingdb() {
# PHP connetion to DB
    $mysqli = new mysqli('localhost', 'matt', 'toor', 'vault');

    # If DB has errored out, assuming the VM is still actually running...
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
	    return false;
   			 } # end connection failed

    else 	{ 
	    # call the script to run mysqldump and overwrite the previous dump
	    $save = '/home/matt/git/UserDatabase/Backup/dump.sh';
	    shell_exec(escapeshellcmd($save));
	    # Amend the log file. 	
	    $dcl = fopen("/home/matt/git/UserDatabase/Backup/dbconn.log",
		    "a+") or die("could not open file");
	    $reg = "DB connection achieved.   ".date("H:i:s")."\n";
	    fwrite($dcl, $reg);
	    fclose($dcl);
	    return true;
   
   		 } # end successful connection 
	} # end pingdb()


	# update i.e. dumptable and scp it to the standby 
	# every sleep(x) seconds while the db connection still returns true.
	# otherwise if the box is running but mysql crashed,
	# write a log message about it. 

	do {
		sleep(10);
		$turn = pingdb();
	
	  }
	while($turn);

