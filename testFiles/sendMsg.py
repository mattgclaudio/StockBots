#!/home/matt/git/rabbitMQMerged/venv/bin/python3

import configparser
import os, sys
from twilio.rest import Client


def getUserNumber(uid):
    config = configparser.ConfigParser()
    config.read('keyring.ini')
    
    headers = config.sections()

    for header in headers:
        if header == str(uid):
            return config[header]["phone"]



def sendAlert(userid, alert):

    account_sid = 'AC4774928d3febf2ab1f54f8df5b028115' 
    auth_token = '0c37eb69e77f374f32a70134c1e52765'
    client = Client(account_sid, auth_token)

    client_number = getUserNumber(userid)

    msg = client.messages \
            .create(
                    body=alert,
                    from_='+18048054083',
                    to=client_number
             )

    print(msg.sid)


sendAlert(1, "testwithadditions")
