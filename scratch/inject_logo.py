import urllib.request
import base64

url = 'https://via.placeholder.com/150/00A859/ffffff?text=LOGO'
req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
with urllib.request.urlopen(req) as response:
    img_data = response.read()

b64_string = base64.b64encode(img_data).decode('utf-8')

file_path = 'resources/views/pdf/service_document.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace the img tag
old_img = '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Logo_Kabupaten_Probolinggo_-_Seal_of_Probolinggo_Regency.svg/512px-Logo_Kabupaten_Probolinggo_-_Seal_of_Probolinggo_Regency.svg.png" alt="Logo Probolinggo">'
new_img = f'<img src="data:image/png;base64,{b64_string}" alt="Logo">'

content = content.replace(old_img, new_img)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated PDF logo to placeholder base64 successfully.')
