#!/home/matt/git/rabbitMQMerged/venv/bin/python3

import configparser
import sys

# this script will ADD an entry to the ini file with the stock
# ticker name and the strike price indicated. indexed in the ini
# file with their userid appeneded to the stockticker name
# passed in with CLI args just like the other scripts


def add_watched_stock(uid, new_stock, new_price):
    config = configparser.ConfigParser()
    tag = str(uid) + new_stock
    config.add_section(tag)

    config[tag]['stock'] = new_stock
    config[tag]['price'] = str(new_price)

    with open('watchedstocks.ini', 'a+') as configfile:
        config.write(configfile)

    print(new_stock + " added with strike price of $" + str(new_price))


add_watched_stock(sys.argv[1], sys.argv[2], sys.argv[3])
