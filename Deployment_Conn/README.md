# Deployment System

The files here are for compressing the needed webpages, php scripts, and config files and sending them to a separate Deployment VM. The compressed package is stored on the
remote Deployment box, and the name given to the package is transmitted with a rabbitMQ message so the Deployment box can add a matching
line for the package in its MYSQL package database table.  
