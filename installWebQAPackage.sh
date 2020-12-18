#!/bin/bash

sudo apt install apache2 libapache2-mod-php7.4 openssl php-amqp php-amqplib php7.4-cli ssl-cert

# apache2 should start automatically

# installing ssl-cert will create a default self-signed 
# certificate and key which we reference in 
# /etc/apache2/sites-available/default-ssl.conf

# $$$$$$$$$$$$
# copy the rabbitmq files to a new directory
# comment this out if you are not me. 
sudo rm -r /home/matt00/git/WebFrontEnd

# $$$$$$$$$$$$
# need this to change the files if you are not me
# not sure how but put your the output of echo $USER in place of $USER

sed -i 's/matt00/FILL_IN_USERNAME_HERE/g' home/matt00/git/WebFrontEnd/
cp -r home/matt00/git/WebFrontEnd/ /home/$USER/git/

# copy web pages to web facing directory

# $$$$$$$$$$$$
#  comment this line out if you dont have this directory
sudo rm -r /var/www/html/stockTracker

# need this to change the files if you are not me

# $$$$$$$$$$$$
# not sure how but put your the output of echo $USER in place of $USER
sed -i 's/matt00/YOUR_USERNAME_HERE/g' var/www/html/stockTracker/

sudo cp -r var/www/html/stockTracker/ /var/www/html/

#copy apache config files to /etc/
sudo rm -r /etc/apache2
sudo cp -r etc/apache2 /etc

# emable ssl on apache2
sudo a2enmod ssl

# enable ssl secured site
sudo a2ensite default-ssl.conf

sudo systemctl reload apache2
