#!/usr/bin/bash

# put things back how they were
cd /var/www/html/stockTracker/
# amend the web php files to use to the failOver configuration 
sed -i 's/FailoverServerClient/ServerClient/g' *.php
# change the server flags
cd /home/matt00/git/WebFrontEnd/

sed -i 's/FLAG = 1/FLAG = 0/g' rabbit.ini
sed -i 's/FLAG = -1/FLAG = 1/g' rabbit.ini

		




