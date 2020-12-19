
ServerClient.php holds all the accessory php functions which the web pages use to package their requests out through the rabbit exchange server. The replaceINI.sh, putbackINI.sh, and monitor.php are run by the user cron to ping the main and failover rabbitdb servers and amend the webpages/ini file flags when the main goes down/comes back up. 

webpages are provided here for the sake of packaging, but naturally they live in /var/www/html. 
