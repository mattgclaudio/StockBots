# Deployment Branch
### Holds code for Deployment VM & functions for the tiers to push and pull packages.

servdep.php is what runs on the Deployment VM and maintains the packages database, sends out version info in response to requests, and holds packages for download.

Deploy.service is put in /lib/systemd/system so that the program will run as a systemd service, can still be controlled through systemctl and online portal.  Modify as needed. 

Usual lib and inc files for RabbitMQ.

ini file, admin admin testHost deployExchange/Queue

