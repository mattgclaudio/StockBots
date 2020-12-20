#!/bin/bash

tar -xzf webPackagebackground.tar.gz

rm webPackagebackground.tar.gz

rm /var/www/html/stockTracker/*

cp var/www/html/stockTracker/* /var/www/html/stockTracker/ 

mkdir webPkgBG

mv var/ webPkgBG

[ ! -d "/home/matt00/Downloads/git/rabbitMQMerged" ] && mkdir -p "/home/matt00/Downloads/git/rabbitMQMerged"

cp -r home/matt00/Downloads/git/rabbitMQMerged/* /home/matt00/Downloads/git/rabbitMQMerged

mv home/ webPkgBG/

echo "Installation Complete"
