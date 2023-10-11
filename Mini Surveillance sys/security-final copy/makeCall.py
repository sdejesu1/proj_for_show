# Find the Sinch phone number assigned to your app
# and your application key and secret
# at dashboard.sinch.com/voice/apps
import requests

key = "REDACTED"
secret = "REDACTED"
fromNumber = "+12064743929"
to = "REDACTED"
locale = "en-US"
url = "https://calling.api.sinch.com/calling/v1/callouts"

payload = {
  "method": "ttsCallout",
  "ttsCallout": {
    "cli": fromNumber,
    "destination": {
      "type": "number",
      "endpoint": to
    },
    "locale": locale,
    "text": "Unfortunately, my friend, your security system has been tripped. Visit your email for a video recording of the event. Thank you for using Steven's Mini Security System! Goodbye."
  }
}

headers = { "Content-Type": "application/json" }

response = requests.post(url, json=payload, headers=headers, auth=(key, secret))

data = response.json()
print(data)
