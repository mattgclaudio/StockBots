# IT490

9/25 14:42

It does not appear that the .conf and .monit files are being used, and it does not seem to impede the flow to have them possibly not being used. Need to ask about their significance. The three .inc files as well as the .ini file are absolutely neccessary for tstRbSrvr.php to function. This has some different output to verify that it has indeed received a message from the Apache2 VM which was driven by the user inputting their credentials. this code as well as the code in Stag will work together to verify that the doItAll() function in the Stag Rabbitclient code, which is called by login.php, runs and prints the server's output to the screen for the website user. The user iputs their data on index.html, it is passed with POST to login.php. Login.php has the code (preceeding the HTML markup) which calls the function that passes the auth credentials to the RabbitVM to be passed to the DB. This function, doItAll(), is almost the entire rabbitClient script wrapped into a single method. Method is just passing dummy code right now though, have to change it to taking the $username and $password as arguments. Right now At this moment SMalishuk is working on the DB end of things and we will attempt to link the whole chain ASAP. 


9/25 14:52

Server needs host.ini to run, excluded this at first.


9/28 3:07AM: Wrote loginScript.php as well as created unifiedServer.php. The function in loginScript.php is passed the credentials which are sent from Apache2, these are sent through rabbit to the DB, which checks the credentials and returns true or false based on whether they were a match. 

unifiedServer.php is just changed to reflect using the loginScript.php, which has to be stored in another dir with its own rabbit.ini file. So long as the request from apache is of type login, the doLogin($un, $pwn) method will be called, passed the credentials, and shoot them to the DB for checking. 

10/20

Right now the RabbitMQ Broker VM Works with switchingserver.php, dmzServer.ini, dbServer.ini, webconn.ini, as well as the usual host path .inc etc files for the rabbit server to run. This coordinates messages between all 3 of the VM's Rabbit being the 4th. 

11/1

No code updates, just want to state that the Rabbit Server VM's code, i.e switchingserver.php, just does the job of forwarding and returning the messages sent from one VM to another based on their requests['type'] var. 
