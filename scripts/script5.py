#!/home/matt/git/rabbitMQMerged/venv/bin/python3


import alpaca_trade_api as tradeapi
import sys

key = "PKOWHBTVHXBZXFDOY8YU"
sec = "sNoRCTp9cK6Y8k4jerXijbPeY15S3MkxcKE4sHGt"
url = "https://paper-api.alpaca.markets"

# Deliverable 1. Keep track of portfolio positions for user.

keyone = sys.argv[1]
keytwo = sys.argv[2]
sym = sys.argv[3]
num = sys.argv[4]

tempconn = tradeapi.REST(keyone, keytwo, url, api_version='v2')

order = tempconn.submit_order(symbol=sym,
                                 qty=num,
                                 side="buy",
                                 type="market",
                                 time_in_force="gtc")
