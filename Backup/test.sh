#!/bin/bash

rm /home/matt/git/UserDatabase/Backup/userbackup.sql
mysqldump vault > /home/matt/git/UserDatabase/Backup/userbackup.sql
