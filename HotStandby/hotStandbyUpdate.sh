#!/bin/bash

# script to be run as a cronjob every x minutes to give the standby
# an up to date userdb copy

cd /home/matt/git

mysqldump vault > UPDATE.sql  

scp UPDATE.sql matt@192.168.1.204:/home/matt/git/UserDatabase

exit 0 
