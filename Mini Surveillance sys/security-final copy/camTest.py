from picamera import PiCamera
from time import sleep
camera = PiCamera()
print("Smile for 5 seconds!")
sleep(5)
camera.capture('image.jpg')
print("Picture captured!")

print("Get ready for camera recording!")
camera.start_recording('testVideo.h264')
sleep(10)
camera.stop_recording()
print("Done!")

