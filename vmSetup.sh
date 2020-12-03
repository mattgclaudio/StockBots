#!/bin/bash
sudo apt-get install git

mkdir git

cd git

git clone https://github.com/smalishuk/rabbitMQMerged/

sudo apt-get install php rabbitmq-server php-amqp*

sudo rabbitmq-plugins enable rabbitmq_management

sudo systemctl restart rabbitmq-server.service

sudo apt install php-mysql

cd ../
