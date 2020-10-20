#!/usr/bin/python3

import alpaca_trade_api as tradeapi
import sys

key = "PKOWHBTVHXBZXFDOY8YU"
sec = "sNoRCTp9cK6Y8k4jerXijbPeY15S3MkxcKE4sHGt"
url = "https://paper-api.alpaca.markets"

# Deliverable 1. Keep track of portfolio positions for user.

keyone = sys.argv[1]
keytwo = sys.argv[2]

tempconn = tradeapi.REST(keyone, keytwo, url, api_version='v2')
assets = (tempconn.list_positions())


print(assets)

# order = tcon.submit_order(symbol="AAPL",
#                                  qty=20,
#                                  side="buy",
#                                  type="market",
#                                  time_in_force="gtc")
