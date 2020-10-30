#!/home/matt/git/rabbitMQMerged/venv/bin/python3

from yahoo_fin.stock_info import *
import pandas as pd
import matplotlib.pyplot as plt
from sklearn.preprocessing import MinMaxScaler
import numpy as np
import tensorflow as tf
from tensorflow import keras
from keras.models import Sequential
from keras.layers import Dense, LSTM
from datetime import date, datetime
import csv
import math
import sys

scl = MinMaxScaler()

plt.style.use('bmh')

pd.options.display.width = 0

#  user must input dates as year-month-day
def predict_price(s_date, e_date, ticker: str):
    
    try:
        all_data = get_data(ticker, start_date=s_date, end_date=e_date).filter(['close'])

    except AssertionError:  # if the function above returns no data
        return False


    # Numpy Array, no dates!
    close_set = all_data.values

    # scale data 0,1
    scaled_set = scl.fit_transform(close_set)

    trainlength = math.ceil((len(close_set) * .8))

    trainset = scaled_set[0:trainlength, :]

    # create training arrays to "fit" the model x train has the data being used to train/fit the model, y_train has the
    # actual result we are looking for, in this case x train has closing costs for 60 days and y_train has the closing
    # cost for the day following the last trading day in x_train x_train holds values i-60:i, y_train has closing cost
    # indexed i. First array is ending exclusive i-1.

    x_train = []
    y_train = []

    for j in range(60, len(trainset)):
        x_train.append(trainset[j - 60:j, 0])  # the 60 days leading UP to the day in question
        y_train.append(trainset[j, 0])  # just the day in question

    # x_train and y_train are now lists, convert to np.array again

    x_train, y_train = np.array(x_train), np.array(y_train)

    # LSTM model requires "3D tensor with  shape [batch, timestep, features] " docs.

    x_train = np.reshape(x_train, (x_train.shape[0], x_train.shape[1], 1))

    # close_model = Sequential()
    # close_model.add(LSTM(units=50, return_sequences=True))
    # close_model.add(LSTM(units=50, return_sequences=False))
    # close_model.add(Dense(units=25))
    # close_model.add(Dense(units=1))

    # load trained model
    close_model = keras.models.load_model('model_29')

    close_model.compile(optimizer="adam", loss='mean_absolute_percentage_error')

    close_model.fit(x_train, y_train, batch_size=1, epochs=1)

    # save the weights of the neurons after the model trains
    close_model.save("model_29")

    testset = scaled_set[trainlength - 60:, :]

    x_test = []
    y_test = close_set[trainlength:, :]  # valid closing cost test data

    for q in range(60, len(testset)):
        x_test.append(testset[q - 60:q, 0])  # 60 days prior --> present day exclusive

    # back to numpy array again
    x_test = np.array(x_test)

    # reshape test array

    x_test = np.reshape(x_test, (x_test.shape[0], x_test.shape[1], 1))

    guess = close_model.predict(x_test)
    guess = scl.inverse_transform(guess)

    rmse_error = np.sqrt(np.mean(((guess - y_test) ** 2)))
    print(rmse_error)

    t = all_data[:trainlength]
    v = all_data[trainlength:]
    v['Predictions'] = guess

    plt.figure(figsize=(16, 8))
    plt.title(ticker + ' Predictions')
    plt.xlabel('Date')
    plt.ylabel('Stock Price', fontsize=18)
    plt.plot(t['close'])
    plt.plot(v[['close', 'Predictions']])
    plt.legend(['Train', 'Valid', 'Predictions'])
    # get the current time, write the file name as time of day, ticker, graph. have to change
    # to year month day.
    now = datetime.now()
    fig_time = now.strftime("%H:%M:%S") + "  " + ticker + "  Graph"
    # save the graph to the publically viewable web directory 
    plt.savefig("/var/www/html/photoHost/test_plot.png")


print(predict_price("2012-1-1", date.today(), sys.argv[1]))



