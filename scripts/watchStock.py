#!/home/matt/git/rabbitMQMerged/venv/bin/python3

from yahoo_fin.stock_info import *
import configparser
import sys, os
from twilio.rest import Client

# send a text message from our Twilio number to the user about the stock
# striking their set price, currently only
# texts me, would have to collect phone numbers,
# store them in keyring.ini and then pull based on uid

def get_number(userid):
    config = configparser.ConfigParser()
    config.read('keyring.ini')
    headers = config.sections()

    for header in headers:
        if (header == str(userid)):
            return config[header]['phone'];


# takes uid to look up phone number, alert containing strike message
def send_alert(alert, uuid):
    # this requires you set these two os env vars with
    # export twilio...="XXXXXXX" in ~/.bashrc
    account_sid = os.environ['TWILIO_ACCOUNT_SID']
    auth_token = os.environ['TWILIO_AUTH_TOKEN']
    client = Client(account_sid, auth_token)
    client_number = get_number(uuid)

    message = client.messages \
                .create(
                     body=alert,
                     from_='+18048054083', # our twilio number
                     to=client_number
                 )


def check_price(ticker, entered_strike_price):
    current_price = get_live_price(ticker)
    if current_price <= entered_strike_price:
        return True
    else:
        return False  # i know this seems insane, but it wasn't returning
                        # false otherwise.


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
                # text this alert to the customer
                send_alert(new_alert, uid)
                
                ret += new_alert
                ret += "\n\n"

            else:
                def_message = " Still no strike for stock " + \
                        ticker_name + " at price " + \
                        strike_price + ", current price is $" + \
                        str(get_live_price(ticker_name)) + "\n\n"
                
                ret += def_message
                ret += "\n\n"
    
    return ret
        


print(watch_stock(sys.argv[1]))
