#!/bin/bash

while ! ping -c1 192.168.1.196 &>/dev/null
	do 
		/bin/sh < /home/matt/git/RabbitVM/switchingserver.php
done

echo "host found - `date`" >> /home/matt/git/UserDatabase/master_conn.log





