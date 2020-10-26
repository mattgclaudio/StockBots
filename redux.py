from yahoo_fin.stock_info import *
import pandas as pd
import matplotlib.pyplot as plt
from sklearn.preprocessing import MinMaxScaler
import numpy as np
from keras.models import Sequential
from keras.layers import Dense, LSTM
scl = MinMaxScaler()

plt.style.use('bmh')
pd.options.display.width = 0

# returned as pandas dataframe

jackal = get_data('AAPL', start_date="2012-1-1", end_date="2020-9-28").filter(['close'])

# print(type(jackal))

# Numpy Array, no dates!
close_set = jackal.values
# scale data 0,1
scaled_set = scl.fit_transform(close_set)

trainlength = 1714

trainset = scaled_set[:trainlength]

testset = scaled_set[trainlength - 60:, :]

# create training arrays to "fit" the model x train has the data being used to train/fit the model, y_train has the
# actual result we are looking for, in this case x train has closing costs for 60 days and y_train has the closing
# cost for the day following the last trading day in x_train x_train holds values i-60:i, y_train has closing cost
# indexed i. First array is ending exclusive i-1.

xtrain = []
ytrain = []

for j in range(60, trainlength):
    xtrain.append(trainset[j-60:j, 0])
    ytrain.append(trainset[j, 0])

# xtrain and ytrain are now lists, convert to numpy array again

xtrain, ytrain = np.array(xtrain), np.array(ytrain)

# LSTM model requires "3D tensor with  shape [batch, timestep, features] " docs.

xtrain = np.reshape(xtrain, (xtrain.shape[0], xtrain.shape[1], 1))

machina = Sequential()
machina.add(LSTM(units=50, return_sequences=True))
machina.add(LSTM(units=50, return_sequences=False))
machina.add(Dense(units=25))
machina.add(Dense(units=1))

machina.compile(optimizer="adam", loss='mean_squared_error')

machina.fit(xtrain, ytrain, batch_size=1, epochs=1)

xtest = []
ytest = close_set[trainlength:, :]

for q in range(60, len(testset)):
    xtest.append(testset[q-60:q, 0])

# back to numpy array again
xtest = np.array(xtest)

# reshape test array

xtest = np.reshape(xtest, (xtest.shape[0], xtest.shape[1], 1))

guess = machina.predict(xtest)
guess = scl.inverse_transform(guess)

error = np.sqrt(np.mean(((guess - ytest)**2)))

t = jackal[:trainlength]
v = jackal[trainlength:]
v['Predictions'] = guess

plt.figure(figsize=(16, 8))
plt.title('AAPL Predictions')
plt.xlabel('Date')
plt.ylabel('Stock Price')
plt.plot(t['close'])
plt.plot(v[['close', 'Predictions']])
plt.legend(['Train', 'Valid', 'Predictions'])
plt.savefig('test_plot.png')
