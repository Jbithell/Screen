import sqlite3
import urllib.request, json  #Web data
import time
import sys
import os #Timezone
#import RPi.GPIO as GPIO #MFRC522
#import MFRC522 #MFRC522
import signal #MFRC522

if sys.version_info[0] < 3:
    import Tkinter as Tk
else:
    import tkinter as Tk

#from yahoo_finance import Currency

#SETTINGS
os.environ['TZ'] = 'Europe/London'
#TODO Get these from Resin.io


def destroy(e):
    sys.exit()
def create_window():
    window = Tk.Toplevel(root)

root = Tk.Tk()
w, h = root.winfo_screenwidth(), root.winfo_screenheight()
root.geometry("%dx%d+0+0" % (w, h)) #Try and fill screen

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

def callback():
    print("Hi")
button = Tk.Button(root, text="OK", command=callback)
button.grid(row=0, column=1, sticky=Tk.N+Tk.E)


#Setup RFID
'''
def endrfidread(signal,frame):
    #This isn't really needed or used - it's just the signal thing fails without it
    GPIO.cleanup()
signal.signal(signal.SIGINT, endrfidread)
MIFAREReader = MFRC522.MFRC522()

def checkrfid():
    global MIFAREReader
    (status, TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
    if status == MIFAREReader.MI_OK:
        print("Card detected")
    (status, uid) = MIFAREReader.MFRC522_Anticoll()
    if status == MIFAREReader.MI_OK:
        print("Card read UID: " + str(uid[0]) + "," + str(uid[1]) + "," + str(uid[2]) + "," + str(uid[3]))
    root.after(1, checkrfid) #Basically a while true
checkrfid()
'''

Tk.mainloop()
