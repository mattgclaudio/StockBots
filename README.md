uhhhh so im throwing this together, i'm PRETTY sure by training it continually it will get better, even a model that works with just one piece of data to make its predictions
im no ML expert, but that is the working theory

after much research it appeared that using NVIDIA hardware was the only way to accelerate the training process, as they have widely available drivers
for using their GPU's to speed up ML training. So...that's what I did.

These files here are the result of me running a tensorflow:gpu Docker container on my local machine, the VM's can't access the hardware directly to make use of
the driver capabilities. right now the redux_2.py script holds a function to predict the stock with 60 days prior of data, and is passed the starting date, ending date, and 
ticker symbol as CLI parameters, saves a graph file with the datetime as its file name and updates the model's weights so in theory 
it will be getting better as i train it on all the major stocks

This is definitely a bit addicting though, the model trains in about 8 seconds with just my RTX 1050ti, aka the cheapest way to get CUDA cores, and it whoops my 12 core CPU which does it in about 48 seconds. 

TODO:

Make python list with a bunch of major stock tickers, have redux_2.py run on all of them to speed up training....im entering each ticker in by hand right now...embarassing. [DONE]


added in a csv file just filled wsith stock ticker symbols to train with, turns out automating it...was not that hard.
function in redux_2.py is called on all the tickers in the csv, imported in the file and turned into a list
tickers are run throuygh the function ina  try except block that excepts Index (not enough entries), Assertion(dont remember what was throwing this but down it goes), and Key(no closing costs?) errors...just to keep things moving along. I dont have an eternity to debug every but of stock data after all. 

just kidding, this isnt doing jack shit. 

will debug...

__commit thank you stackoverflow__:
switched graphics cards and then spent a fun day debugging horrible tensorflow errors

there are 2 lines at the beginning of final_bot_1.py that fixed that problem...

still having trouble running the huge set of stocks because so many of them dont return any useable data and im not yet sure how to just SKIP them entirely
without messing things up. probably not a complicated fix but im focusing on what WORKS at the moment.

To that end, I can iterate over a manually coded python list of stocks (which i know ill get years worth of data for) plugging each one into the model to test it
which saves a lot of time even if hard coding the list is slow vs sorting the 2000 row csv file. just_Tickers.csv

anyway the model *seems* to get quite a bit better with training, it pulls 8 years of closing costs for each symbol and this commit ran 15 symbols, their graphs were uploaded sequentially (the names have the timestamp). as you can see the predictions get near dead on in some of the later ones. Still not putting my money into it though.
