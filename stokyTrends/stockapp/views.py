from django.shortcuts import render
from . import graph_generator,prediction

def graph_view(request):
    if request.method == 'POST':
        symbol = request.POST['symbol']
        data = graph_generator.gettingdata(symbol)
        traindata = graph_generator.preprocess(data)

        current_price=traindata['price'].tail(1)
        current_price="%.2f" % round(current_price,2)


        fig = graph_generator.graph(traindata)
        graph_html = fig.to_html(full_html=False)
        description = graph_generator.describe(data)
        description_html = description.to_html()

        start_date = request.POST.get('start_date', '')  # Get start_date or use an empty string as default
        end_date = request.POST.get('end_date', '')  # Get end_date or use an empty string as default
        
        if start_date and end_date:  # Check if both start_date and end_date are provided
            modified_fig = graph_generator.generate_graph(traindata, start_date, end_date)
            modified_graph_html = modified_fig.to_html(full_html=False)
        else:
            modified_graph_html = None  # Set modified_graph_html to None if start_date or end_date is missing

        context = {'graph_html': graph_html, 'symbol': symbol, 'description_html': description_html, 'modified_graph_html': modified_graph_html,'current_price':current_price,"start_date":start_date,"end_date":end_date}
        return render(request, 'trends.html', context)
    return render(request, 'trends.html')

def stock_prediction(request):
        data = graph_generator.gettingdata('amzn')
        preprocessed_data = prediction.preprocessing_for_prediction(data)
        x_train, y_train = prediction.splitting_data(preprocessed_data)
        y_pred = prediction.predict(x_train)
        
        fig = prediction.plotting_graph(y_train, y_pred)
        prediction_fig_html = fig.to_html(full_html=False, include_plotlyjs='cdn')

        context = {'prediction_fig_html': prediction_fig_html}
        return render(request, 'prediction.html', context)


