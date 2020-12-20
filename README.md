# StockBots Project

All the code contained within this repo is 100% my own creation with the exception of the files:
rabbitMQlib.inc, 
get_host_info.inc, 
path.inc, 
host.ini
and local.ini 
which were provided to me with some prebuilt functions for creating RabbitMQ servers and clients. 


The code contained here was to be distributed among 3 VM's, a Web Front End, a DMZ to connect to the Alpaca Trading API, and a box to serve as the RabbitMQ broker as well as a database for users logging in through the web front end. All VMs used for creation of this project were running Ubuntu 18.04.

### START -> webVM  

  The Web Front End has a login page which sends the username and password to to passthrough.php, these are wrapped in a rabbitMQ request and sent through the rabbitMQ Broker box to the the user database for authentication.
  
  
 ### Credentials send to RabbitVM -->
  Because the user DB and rabbit broker are on the same box, the broker just forwards the request to the locally running database server rabbit listener, which runs the credentials and returns the user's UID if one exists in the system. This UID is tied to the user's API keys which are needed for performing an action on the API. Trading keys are kept on the DMZ in an ini file and retrieved on a per-use basis. 
  
###  UID sent back to WebFrontEnd --> 
   If a proper UID is returned, the user is moved to the check.php page where they can check their balance/open positions or move to any of the other pages within the system. Requests from any of these pages correspond to PHP functions kept in the webVM's ServerClient.php file. For most of them, it involves packaging the UID as well as a code for the action being performed which corresponds to a switch function case on the DMZ, which has a number of accessory functions for handling each unique user request. 
  
### User sends requests through broker to DMZ -->
After authenticating, the user's UID is stored as a PHP session variable within the webpages and passed to accessory functions when they perform an action on the site.  
  
