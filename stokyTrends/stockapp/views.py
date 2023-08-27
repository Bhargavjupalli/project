# stockapp/views.py
from django.shortcuts import render
from . import graph_generator

def graph_view(request):
    if request.method == 'POST':
        symbol = request.POST['symbol']
        data = graph_generator.gettingdata(symbol)
        traindata = graph_generator.preprocess(data)

        fig = graph_generator.graph(traindata)
        graph_html = fig.to_html(full_html=False)
        description = graph_generator.describe(data)
        description_html = description.to_html()
        context = {'graph_html': graph_html, 'symbol': symbol, 'description_html': description_html}
        return render(request, 'trends.html', context)
    return render(request, 'trends.html')

def modified_graph(request):
    if request.method == 'POST':
        start_date = request.POST['start_date']
        end_date = request.POST['end_date']
        symbol = request.POST['symbol']
        data = graph_generator.gettingdata(symbol)
        traindata = graph_generator.preprocess(data)
        fig1 = graph_generator.generate_graph(traindata, start_date, end_date)
        newgraph_html = fig1.to_html(full_html=False)
        context = {'newgraph_html': newgraph_html}  # Use 'newgraph_html' key
        return render(request, 'trends.html', context)
    return render(request, 'trends.html')
