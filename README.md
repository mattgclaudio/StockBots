uhhhh so im throwing this together, i'm PRETTY sure by training it continually it will get better, even a model that works with just one piece of data to make its predictions
im no ML expert, but that is the working theory

after much research it appeared that using NVIDIA hardware was the only way to accelerate the training process, as they have widely available drivers
for using their GPU's to speed up ML training. So...that's what I did.

These files here are the result of me running a tensorflow:gpu Docker container on my local machine, the VM's can't access the hardware directly to make use of
the driver capabilities. right now the redux_2.py script holds a function to predict the stock with 60 days prior of data, and is passed the starting date, ending date, and 
ticker symbol as CLI parameters, saves a graph file with the datetime as its file name and updates the model's weights so in theory 
it will be getting better as i train it on all the major stocks.
