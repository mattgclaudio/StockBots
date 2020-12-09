from yahoo_fin.stock_info import *
import configparser
import sys


def check_price(ticker, entered_strike_price):
    current_price = get_live_price(ticker)
    if current_price <= entered_strike_price:
        return True
    else:
        return False


def watch_stock(uid):
    return_message = ""

    config = configparser.ConfigParser()
    config.read('watchedstocks.ini')

    headers = config.sections()

    for header in headers:
        if header.startswith(str(uid)):
            ticker_name = config[header]['stock']
            strike_price = config[header]['price']
            flag = check_price(ticker_name, int(strike_price))
            if flag:
                return_message += ticker_name + " has struck below your set price of $" + strike_price + \
                                  " at $" + str(get_live_price(ticker_name)) + "  \n"

            else:
                return_message += " Still no strike for stock " + ticker_name + " at price " + strike_price + "\n"

    return return_message


print(watch_stock(sys.argv[1]))
