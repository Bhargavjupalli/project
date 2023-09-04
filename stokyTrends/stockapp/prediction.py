import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
from sklearn.preprocessing import MinMaxScaler
from tensorflow import keras
from keras.models import Model
from keras.models import load_model
import plotly.express as px


# load model
savedModel=load_model("C:\\Users\\bhargav\\project-1\\stokyTrends\\stockapp\\LSTM_model")

def preprocessing_for_prediction(data):
    if data['close'].dtype == 'object':
        data['close']=pd.to_numeric(data['close'],errors='coerce')
    traindata=data.loc[:,['close']]
    traindata.dropna(axis=0,inplace=True)
    sc = MinMaxScaler(feature_range=(0,1))
    preprocessed_data = sc.fit_transform(traindata)
    return preprocessed_data
def splitting_data(preprocessed_data):
    x_train = []
    y_train = []
    for i in range (60,1149): #60 : timestep // 1149 : length of the data
        x_train.append(preprocessed_data[i-60:i,0]) 
        y_train.append(preprocessed_data[i,0])

    x_train,y_train = np.array(x_train),np.array(y_train)
    return x_train,y_train

def predict(x_train):
    y_pred = savedModel.predict(x_train)
    return y_pred

def plotting_graph(y_train, y_pred):
    # Reshape y_pred to be 1-dimensional
    y_pred_1d = y_pred.flatten()
    
    # Create a DataFrame to hold the actual values
    data = pd.DataFrame({'Actual': y_train}, index=np.arange(len(y_train)))
    
    # Create a Series for the predicted values with the same index as y_train
    predicted_series = pd.Series(y_pred_1d, index=np.arange(len(y_train)))
    
    # Create a line plot using Plotly Express
    fig = px.line(data, title='Stock Price Prediction', labels={'index': 'Time', 'value': 'Stock Price'})
    
    # Add the predicted values to the plot
    fig.add_scatter(x=data.index, y=predicted_series, mode='lines', line=dict(color='green'), name='Predicted Stock Price')
    
    # Customize the appearance of the plot if needed
    fig.update_traces(line=dict(color='red'), name='Actual Stock Price')
    fig.update_layout(xaxis_title='Time', yaxis_title='Stock Price')
    fig.update_layout(legend=dict(yanchor="top", y=0.99, xanchor="left", x=0.01))
    
    # Show the Plotly graph
    return fig
