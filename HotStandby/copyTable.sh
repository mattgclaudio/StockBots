#!/bin/bash

# script to be run as a cronjob every x minutes to give the standby
# an up to date userdb copy


mysqldump vault > /home/matt/git/userdbUPDATE.sql

exit 0 
