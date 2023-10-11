from gpiozero import LED  # import the LED library from the gpiozero
from gpiozero import Buzzer # import buzzer from gpiozero
from gpiozero import MotionSensor  # import the MotionSensor library
import runpy # importing runpy to run other scripts within this one
import time # importing time for a "reset" function
from time import sleep
import os # importing os to convert video recording
import camEmail2 # reporting camera to email file to use its functions

buzzer = Buzzer(17) # declare gpio for buzzer
led = LED(14)  # declare the GPIO pin 14 for the led output
sensor = MotionSensor(4)  # declare the GPIO pin 4 as motion sensor output
led.off()  # turn off the LED

def main():  
    while True:  # initialize a infinite while loop       
        print("Waiting for motion sensor...")
        sensor.wait_for_motion()  # it will wait for the motion detection
        led.on()  # turn on the LED
        buzzer.on() # turn on the buzzer
        print("Motion sensor tripped!")

        inMakeEmail() # calling camera to email script

        inMakeCall() # function call to make the call
                        
        sensor.wait_for_no_motion()  # it will wait for the motion detection
        print("No more motion, sensor off...")
        led.off()  # turn off the LED    
        buzzer.off() # turn off the buzzer
        time.sleep(5)

        if input('Continue?: (y/n)\n')  == 'n':    
            print("Thank you for using my security system!")
            return False # to quit program



# function that calls outside makeCall.py script and uses a timer for a space between calls
def inMakeCall():
    runpy.run_path(path_name = 'makeCall.py') # using runpy to call outside script
    print("Resetting system...")
    time.sleep(5)


def inMakeEmail():
    camEmail2.capture_video()
    #time.sleep(2)
    res=os.system("MP4Box -add surveilance.h264 surveilance.mp4")
    camEmail2.send_email()
    #time.sleep(2)
    camEmail2.remove_file()


if __name__ == '__main__':
    main()

