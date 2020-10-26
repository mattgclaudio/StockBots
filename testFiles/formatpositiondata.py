#!/bin/python3

import alpaca_trade_api as tradeapi
import sys

key = "PKOWHBTVHXBZXFDOY8YU"
sec = "sNoRCTp9cK6Y8k4jerXijbPeY15S3MkxcKE4sHGt"
url = "https://paper-api.alpaca.markets"

# Deliverable 1. Keep track of portfolio positions for user.

tempconn = tradeapi.REST(key, sec, url, api_version='v2')

# tempconn = tradeapi.REST(sys.argv[1], sys.argv[2], url, api_version='v2')

assets = (tempconn.list_positions())


def posdata(pos):
    sret = ""
    sret += (("Symbol:  " + pos.__getattr__('symbol')) + 
    ("\nQuantity:  " + pos.__getattr__('qty')) + 
    ("\nAsset Class:  " + pos.__getattr__('asset_class')))
    
    return sret


def getallpos(allpos):
    retarr = {}
    for k in range(len(allpos)):
        retarr[k] = posdata(allpos[k])
    return retarr

print(getallpos(assets))


# order = tcon.submit_order(symbol="AAPL",
#                                  qty=20,
#                                  side="buy",
#                                  type="market",
#                                  time_in_force="gtc")
