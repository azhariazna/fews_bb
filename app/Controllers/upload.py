import requests

file_path = 'D:/Genangan - Copy.json'
url = 'https://faa6-36-69-250-3.ngrok-free.app/fews_bb/upload-api'  # pastikan ini adalah endpoint CI4 kamu

with open(file_path, 'rb') as f:
    files = {'file': f}
    response = requests.post(url, files=files)

print("Status Code:", response.status_code)
print("Response:", response.text)
