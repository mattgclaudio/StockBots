 

insert apache2/ports.conf into /etc/apache2, 
defaultssl into sites-available,
enable with a2dissite <anything thats up>,
and a2ensite defaultssl && a2enmod ssl if not already enabled.
uses the automatic cert generation with the spt  certbot package
/etc/hosts must also have a top line with 127.0.0.1 www.stocktracker.com
