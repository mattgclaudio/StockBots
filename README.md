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

Make python list with a bunch of major stock tickers, have redux_2.py run on all of them to speed up training....im entering each ticker in by hand right now...embarassing. 


added in a csv file just filled wsith stock ticker symbols to train with, turns out automating it...was not that hard.
function in redux_2.py is called on all the tickers in the csv, imported in the file and turned into a list
tickers are run throuygh the function ina  try except block that excepts Index (not enough entries), Assertion(dont remember what was throwing this but down it goes), and Key(no closing costs?) errors...just to keep things moving along. I dont have an eternity to debug every but of stock data after all. 
