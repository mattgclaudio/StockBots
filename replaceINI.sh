#!/usr/bin/bash


cd /var/www/html/stockTracker/
# amend the web php files to use to the failOver configuration 
sed -i 's/ServerClient.php/FailoverServerClient.php/g' *.php
# change the server flags
cd /home/matt00/git/WebFrontEnd/

sed -i 's/FLAG = 1/FLAG = -1/g' rabbit.ini
sed -i 's/FLAG = 0/FLAG = 1/g' rabbit.ini

		




