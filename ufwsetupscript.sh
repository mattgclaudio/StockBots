#!/bin/bash

# sudo apt install ufw

# make sure /etc/default/ufw : IPV6=yes


sudo ufw default deny incoming
sudo ufw default allow outgoing

sudo ufw allow ssh

sudo ufw allow 5672

sudo ufw allow 80

sudo ufw allow 443

sudo ufw allow from 10.192.0.0/19
sudo ufw allow from 192.168.1.0/24


sudo ufw reload


