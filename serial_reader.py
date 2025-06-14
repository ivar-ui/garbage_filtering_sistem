import serial  # type: ignore
import requests

# Konfigurasi Serial
try:
    ser = serial.Serial('COM6', 9600, timeout=2)
    print("Serial port terbuka:", ser.portstr)
except Exception as e:
    print("Gagal membuka serial:", e)
    exit()

while True:
    try:
        if ser.in_waiting:
            line = ser.readline().decode('utf-8', errors='ignore').strip()
            print(f"Read from Arduino: {line}")

            if "jenis=" in line and "kelembapan=" in line:
                # Parsing string format: jenis=basah&kelembapan=87
                parts = line.split("&")
                data = {}

                for part in parts:
                    if "=" in part:
                        k, v = part.split("=")
                        data[k.strip()] = v.replace("%", "").strip()

                # Debug print parsed data
                print("Parsed Data:", data)

                # Kirim data ke Laravel API
                try:
                    r = requests.post("http://localhost:8000/api/waste_data", data=data)
                    print(f"Sent to Laravel, response: {r.status_code} | {r.text}")
                except requests.exceptions.RequestException as err:
                    print(f"Request error: {err}")
    except Exception as e:
        print(f"Loop error: {e}")
