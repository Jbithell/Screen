import matplotlib
matplotlib.use('TkAgg')

from numpy import arange, sin, pi
from matplotlib.backends.backend_tkagg import FigureCanvasTkAgg
from matplotlib.figure import Figure
import matplotlib.dates as mdates
import matplotlib.pyplot as plt
import sqlite3
import urllib.request, json  #Web data
import datetime
from datetime import date, timedelta
import time
import sys
if sys.version_info[0] < 3:
    import Tkinter as Tk
else:
    import tkinter as Tk

#from yahoo_finance import Currency

#SETTINGS
currencies = ["USD", "GBP", "EUR"]
base = "USD"
#TODO Get these from Resin.io


def destroy(e):
    sys.exit()

root = Tk.Tk()
#root.attributes("-fullscreen", True)
w, h = root.winfo_screenwidth(), root.winfo_screenheight()
root.geometry("%dx%d+0+0" % (w, h)) #Try and fill screen

root.columnconfigure(1, weight=1)
root.rowconfigure(1, weight=1)

#Data setup
db = sqlite3.connect('database.db')
cursor = db.cursor()

def currencyget(base,currency,date):
    time.sleep(0.2) #https://github.com/hakanensari/fixer-io
    urlrequest = urllib.request.urlopen("http://api.fixer.io/" + date + "?symbols=" + currency + "&base=" + base).read()
    dowloadeddata = urlrequest.decode("utf8")
    data = json.loads(str(dowloadeddata))
    if len(data['rates']) < 1:
        return False
    else:
        return int(data['rates'][currency])

def refreshdb():
    global currencies, base
    print("Running stock update")
    for currency in currencies:
        if currency == base:
            continue

        cursor.execute('''SELECT day,month,year,value FROM data WHERE currency="''' + currency + '" AND base="' + base + '" ORDER BY year DESC, month DESC, day DESC')
        searchdata = cursor.fetchall()
        if len(searchdata) < 1:
            updateto = str(date(2005, 1, 1))
        else:
            updateto=datetime.date(searchdata[0][2], searchdata[0][1], searchdata[0][0])+timedelta(days=1)
        delta = datetime.date.today() - updateto
        for date in range(delta.days +1):
            thisdate = updateto + timedelta(days=date)
            thisvalue = currencyget(base,currency,thisdate.strftime("%Y-%m-%d"))
            if (thisvalue):
                cursor.execute('INSERT INTO data (currency,value,base,day,month,year) VALUES ("' + str(currency) + '","' + str(thisvalue) + '","' + str(base) + '","' + thisdate.strftime("%d") + '","' + thisdate.strftime("%m") + '","' + thisdate.strftime("%Y") + '")')
                db.commit()

refreshdb()

#Full Graph setup
f = plt.figure(figsize=(5, 4), dpi=100)
a = f.add_subplot(111)
key = []
for currency in currencies:
    if currency == base:
        continue

    cursor.execute(
        '''SELECT day,month,year,value FROM data WHERE currency="''' + currency + '" AND base="' + base + '" ORDER BY year,month,day ASC')
    search2data = cursor.fetchall()
    thiscurrencyvalues = []
    thiscurrencydates = []
    for i in search2data:
        if isinstance(i[3], float): #Sometimes it writes errors to the db - ignore them1

            thiscurrencyvalues.append((1/i[3]))
            thiscurrencydates.append(str(i[0]) + "/" + str(i[1]) + "/" + str(i[2]))
    a.plot(list(map(datetime.datetime.strptime, thiscurrencydates, len(thiscurrencydates)*['%d/%m/%Y'])), thiscurrencyvalues)
    key.append(currency)

a.legend(key, loc='upper left', title="")
a.set_title('FX Markets (post 05)')
a.set_ylabel("Pegged against " + base)

#Last month
currencylastmonthf = plt.figure(figsize=(5, 4), dpi=100)
currencylastmontha = currencylastmonthf.add_subplot(111)
currencylastmonthkey = []
for currency in currencies:
    if currency == base:
        continue
    currencylastmonthtimerange = date.today() - timedelta(days=40)
    cursor.execute(
        '''SELECT day,month,year,value FROM data WHERE currency="''' + currency + '" AND base="' + base + '" AND day >= "' + currencylastmonthtimerange.strftime("%d") + '" AND month >= "' + currencylastmonthtimerange.strftime("%m") + '" AND year >= "' + currencylastmonthtimerange.strftime("%Y") + '" ORDER BY year,month,day ASC')
    search2data = cursor.fetchall()
    thiscurrencyvalues = []
    thiscurrencydates = []
    for i in search2data:
        if isinstance(i[3], float): #Sometimes it writes errors to the db - ignore them1
            thiscurrencyvalues.append((1/i[3]))
            thiscurrencydates.append(str(i[0]) + "/" + str(i[1]) + "/" + str(i[2]))
    currencylastmontha.plot(list(map(datetime.datetime.strptime, thiscurrencydates, len(thiscurrencydates)*['%d/%m/%Y'])), thiscurrencyvalues)
    currencylastmonthkey.append(currency)

currencylastmontha.legend(currencylastmonthkey, loc='upper left', title="Pegged against " + base)
currencylastmontha.set_title('FX Markets (40 days)')
currencylastmontha.xaxis.set_major_formatter(mdates.DateFormatter('%d %b'))
currencylastmontha.set_ylabel("Pegged against " + base)


# a tk.DrawingArea
canvas = FigureCanvasTkAgg(f, master=root)
canvas.show()
#canvas.get_tk_widget().pack(side=Tk.RIGHT, fill=Tk.BOTH, expand=1)
#canvas._tkcanvas.pack(side=Tk.RIGHT, fill=Tk.BOTH, expand=1)
canvas.get_tk_widget().grid(row=1, column=1, sticky=Tk.N+Tk.S+Tk.E+Tk.W)

currencylastmonthcanvas = FigureCanvasTkAgg(currencylastmonthf, master=root)
currencylastmonthcanvas.show()
currencylastmonthcanvas.get_tk_widget().grid(row=1, column=2, sticky=Tk.N+Tk.S+Tk.E+Tk.W)


button = []
for i in range(0,10):
    button.append(i)
    button[i] = Tk.Button(master=root, text='[1] Test', command=sys.exit)
    #button[i].pack(side=Tk.BOTTOM)
    button[i].grid(row=2, column=1)

button2 = Tk.Button(master=root, text='[1] Test', command=sys.exit)
#button2.pack(side=Tk.LEFT)
button2.grid(row=1, column=0)
button3 = Tk.Button(master=root, text='[1] Test', command=sys.exit)
#button2.pack(side=Tk.LEFT)
button3.grid(row=0, column=0)
def keydown(e):
    print('down', e.keysym)
root.bind("<KeyPress>", keydown)


#   Clock
time1 = ''
clock = Tk.Label(root, font=('times', 20, 'bold'), bg='white')
clock.grid(row=0, column=2, sticky=Tk.N+Tk.E)
def tick():
    global time1
    # get the current local time from the PC
    time2 = time.strftime('%A %d %b %Y %I:%M:%S %p')
    # if time string has changed, update it
    if time2 != time1:
        time1 = time2
        clock.config(text=time2)
    # calls itself every 200 milliseconds
    # to update the time display as needed
    # could use >200 ms, but display gets jerky
    clock.after(200, tick)
tick()
#Tube status
tubeshiftmessage = Tk.StringVar()
tubeshiftmessagestring = ""
def tubeshif():
    global tubeshiftmessagestring, tubeshiftmessage
    if (len(tubeshiftmessagestring) > 0):
        tubeshiftmessagestring =  tubeshiftmessagestring[1:] +  tubeshiftmessagestring[0]
    tubeshiftmessage.set(tubeshiftmessagestring)
    root.after(100, tubeshif)
tubeshif()
tube = Tk.Label(root, font=('times', 20, 'bold'), width=100, bg='white', textvariable=tubeshiftmessage)
tube.grid(row=0, column=1, sticky=Tk.N+Tk.S+Tk.E+Tk.W)

def updatetube():
    global tubeshiftmessagestring
    page = urllib.request.urlopen('http://jbithell.com/projects/screen/3/ajax/tubestatus.php')
    tubeshiftmessagestring = str(page.read().decode("utf8")) + "        "
    print("Updating Tube Status")
    tube.after(5*60*1000, updatetube) #Refresh every 5 minutes
updatetube()

Tk.mainloop()
