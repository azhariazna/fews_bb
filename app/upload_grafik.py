import pandas as pd
import json
import requests

# Baca file Excel
file_path = 'D:/Er_Das_Rea/Dashbord_Das_Rea_v1.xlsm'
sheet_name = 'upload web'

# Baca baris 3 sampai 146 (index Excel) → baris 2 sampai 145 (index Python)
df = pd.read_excel(
    file_path,
    sheet_name=sheet_name,
    usecols="A,C,D",
    skiprows=2,
    nrows=144
)

# Ubah nama kolom
df.columns = ['id', 'jam', 'debit']

# Hapus baris kosong jika ada
df.dropna(subset=['id', 'jam', 'debit'], inplace=True)

# Konversi ke list of dicts
data_list = df.to_dict(orient='records')

# Cetak sebagai JSON
print(json.dumps(data_list, indent=2))

# === Kirim ke endpoint CI4 ===
url = 'http://127.0.0.1/api/bulk-update-data'  # Ganti jika pakai port atau domain lain
headers = {'Content-Type': 'application/json'}

try:
    response = requests.post(url, headers=headers, json=data_list)
    print("\n[✔] Response:", response.status_code)
    print(response.json())
except Exception as e:
    print("\n[✘] Gagal mengirim data:", e)
