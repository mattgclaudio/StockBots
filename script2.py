

#!/usr/bin/python3

import alpaca_trade_api as tradeapi
import sys

# key = "PKOWHBTVHXBZXFDOY8YU"
# sec = "sNoRCTp9cK6Y8k4jerXijbPeY15S3MkxcKE4sHGt"
url = "https://paper-api.alpaca.markets"

# Deliverable 1. Keep track of portfolio positions for user.


temp_conn = tradeapi.REST(sys.argv[1], sys.argv[2], url, api_version='v2')
assets = (temp_conn.list_positions())


def pos_data(pos):
    stock = {
        "Symbol": pos.__getattr__('symbol'),
        "Quantity": pos.__getattr__('qty'),
        "Asset Class": pos.__getattr__('asset_class')

    }
    return stock


def get_all_pos(all_positions):
    all_stocks = set()

    for k in range(len(all_positions)):
        all_stocks.add(pos_data(all_positions[k]).get("Symbol") + "   "
                       + pos_data(all_positions[k]).get("Quantity") + "  "
                       + pos_data(all_positions[k]).get("Asset Class"))
    return all_stocks


print(get_all_pos(assets))
