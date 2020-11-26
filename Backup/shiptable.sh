#!/bin/bash

tar -czf usertable.tar.gz /home/matt/git/UserDatabase/Backup/userbackup.sql

scp usertable.tar.gz matt@192.168.1.185:/home/matt/git/dbBackups

rm usertable.tar.gz
