#!/home/matt/git/rabbitMQMerged/venv/bin/python3

from yahoo_fin.stock_info import *
import configparser
import sys, os
from twilio.rest import Client
#
# Somehow or other, we could pass the uid to this script and have it run 
# continually in the background so it would text you
# the instant a stock struck a given price. 
#
# send a text message from our Twilio number to the user about the stock
# striking their set price, currently only
# texts me, would have to collect phone numbers,
# store them in keyring.ini and then pull based on uid

def send_alert(alert):
    account_sid = 'AC4774928d3febf2ab1f54f8df5b028115'
    auth_token = '6950d7afe113961ccef0420fdda26ef3'

    client = Client(account_sid, auth_token)
    
    message = client.messages \
                .create(
                     body=alert,
                     from_='+18048054083',
                     to='+19739081950'
                 )


def check_price(ticker, entered_strike_price):
    current_price = get_live_price(ticker)
    if current_price <= entered_strike_price:
        return True
    else:
        return False


def watch_stock(uid):
    ret = ""

    config = configparser.ConfigParser()
    config.read('watchedstocks.ini')

    headers = config.sections()

    for header in headers:
        if header.startswith(str(uid)):
            ticker_name = config[header]['stock']
            strike_price = config[header]['price']
            flag = check_price(ticker_name, int(strike_price))
            if flag:
                new_alert = ticker_name + \
                        " has struck below your set price of $" + \
                        strike_price + " at $" + \
                        str(get_live_price(ticker_name))
                send_alert(new_alert)
                
        
watch_stock(sys.argv[1])

