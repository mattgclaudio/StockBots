# Web Front End Code

12/19/2020

**Webpage config:**

  All webpages held in FINALwebpages, live in /var/www/html/stockTracker.
  ServerClient.php holds all the accessory php functions which the web pages use to package their requests out through the rabbit exchange server.
  get_host_info.inc, host.ini, local.ini, path.inc, rabbitMqlib.inc, ServerClient.php, and rabbit.ini all go in a directory with ServerClient.php
  
**Database/Rabbit Broker Failover:**

The replaceINI.sh, putbackINI.sh, and monitor.php are run by the user cron to ping the main and failover 
rabbitdb servers and amend the webpages/ini file flags when the main goes down/comes back up.

**For SSL config:** 
   Insert apache2/ports.conf into /etc/apache2, defaultssl into sites-available, enable with a2dissite , and a2ensite defaultssl && a2enmod ssl if not already enabled.
uses the automatic cert generation with the spt certbot package 
/etc/hosts must also have a top line with 127.0.0.1 www.stocktracker.com
