# rStockBots Project

The code contained here was to be distributed among 3 VM's, a Web Front End, a DMZ to connect to the Alpaca Trading API, and a box to serve as the RabbitMQ broker as well as a database for users logging in through the web front end. 

START -> webVM  

  The Web Front End has a login page which sends the username and password to to passthrough.php, these are wrapped in a rabbitMQ request and sent through the rabbitMQ Broker box to the the user database for authentication. Once authenticated the user is moved to the check.php page where they can check their balance/open positions or move to any of the other pages within the system. 
