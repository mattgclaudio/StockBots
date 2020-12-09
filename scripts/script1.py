#!/home/matt/git/rabbitMQMerged/venv/bin/python3

import alpaca_trade_api as tradeapi
import sys, os

jackal = sys.argv[1]
luna = sys.argv[2]

key = "PKOWHBTVHXBZXFDOY8YU"
sec = "sNoRCTp9cK6Y8k4jerXijbPeY15S3MkxcKE4sHGt"
url = "https://paper-api.alpaca.markets"

# Deliverable 1. Keep track of cash account for user.


# make a connection to the users account
tempconn = tradeapi.REST(jackal, luna, url, api_version='v2')

# prints amount of free cash and the currency
cashres = ("Cash:\t" + tempconn.get_account().__getattr__('cash') +
           "\t" + tempconn.get_account().__getattr__('currency'))


print(cashres)
