from flask import Flask,render_template,request
import pickle
app=Flask(__name__)



@app.route('/',methods=['POST','GET'])
def home():
    if request.method=='GET':
        return render_template('index.html')
    else:
        Type=request.form.get('Type')
        Air_temp=float(request.form.get('air_temperature'))
        Process_temp=float(request.form.get('process_temperature'))
        Rotational_speed=float(request.form.get('rotational_speed'))
        Torque=float(request.form.get('torque'))
        Tool_wear=float(request.form.get('tool_wear'))
        if Type =='M':
            Type =2
        elif Type =='L':
            Type =1
        else:
            Type =0
        
        model = pickle.load(open('model.sav', 'rb'))
        def predict(model,Type,Air_temp,Process_temp,Rotational_speed,Torque,Tool_wear):
            pred_value=model.predict([[Type,Air_temp,Process_temp,Rotational_speed,Torque,Tool_wear]])
            return pred_value
        value=predict(model,Type,Air_temp,Process_temp,Rotational_speed,Torque,Tool_wear)
        def failure_name(val):
            if val==0:
                return 'No Failure'
            elif val==1:
                return 'Heat dissipation Falilure'
            elif value==2:
                return 'Power Failure'
            elif value==3:
                return 'Overstarin Failure'
            elif value==4:
                return 'Tool wear Failure'
            elif value==5:
                return 'Random Failure'
            elif value==6:
                return 'Failed'
        def status(value):
            if value==0:
                return 'Running Good'
            else:
                return 'Failed'
        status=status(value)
        output=failure_name(value)
    return render_template('index.html',result=output,status=status)
if __name__ == '__main__':
    app.run(host='0.0.0.0')

    

