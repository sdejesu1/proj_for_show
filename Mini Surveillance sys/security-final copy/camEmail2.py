import smtplib
import ssl
import os
import email
from email.mime.base import MIMEBase
from email.mime.application import MIMEApplication
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email import encoders

from picamera import PiCamera
from time import sleep
from datetime import datetime

# Define the transport variables
ctx = ssl.create_default_context()
password = "REDACTED"    # Your app password goes here
sender = "serpiconia1997@gmail.com"    # Your e-mail address
receiver = "stevendejesus5678@gmail.com" # Recipient's address

# Pi Camera
camera = PiCamera() # initiaing pi camera
camera.rotation = 180 # flipping the camera
# function to send the email
def send_email():
    # Create the message
    message = MIMEMultipart("mixed")
    message["Subject"] = "Security Alert: Your security system has been tripped!"
    message["From"] = sender
    message["To"] = receiver

    # Attach message body content
    message.attach(MIMEText("Hello,\n\n\tUnwanted motion has been detected at your location, and it may be a threat. Please check the video recording of the event, recorded by the mini security system.\n\nRegards,\nSteven's Mini Security System", "plain"))

    # Attach image
    filename = 'surveilance.mp4'
    with open(filename, "rb") as f:
        file = MIMEApplication(f.read())
    disposition = f"attachment; filename={filename}"
    file.add_header("Content-Disposition", disposition)
    message.attach(file)

    # Connect with server and send the message
    with smtplib.SMTP_SSL("smtp.gmail.com", port=465, context=ctx) as server:
        server.login(sender, password)
        server.sendmail(sender, receiver, message.as_string())
    print("Email sent!")

def capture_video():
    print("Recording of 10 seconds starting...")
    camera.start_recording('surveilance.h264')
    camera.wait_recording(10)
    camera.stop_recording()
    print("Recording done!")


def remove_file():
    if os.path.exists("surveilance.mp4"): 
        os.remove("surveilance.mp4")
    if os.path.exists("surveilance.h264"):
        os.remove("surveilance.h264")
        print("Files successfully removed from local system.")
    else:
        print("Files do not exist.")


# Main code for method call 
def main():
    print("Motion Detected!")
    capture_video()
    sleep(2)
    res=os.system("MP4Box -add surveilance.h264 surveilance.mp4")
    send_email()
    sleep(2)
    remove_file()


if __name__ == "__main__":
    main()
