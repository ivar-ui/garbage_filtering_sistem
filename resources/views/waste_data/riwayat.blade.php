<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Riwayat Sensor</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-[#0f172a] text-white min-h-screen flex">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-[#1e293b] p-6 flex flex-col gap-6 min-h-screen shadow-xl">
    <div class="text-2xl font-bold mb-6">Dashboard</div>
    <nav class="flex flex-col gap-3">
      <a href="{{ route('data.sampah') }}" class="hover:bg-[#334155] px-4 py-2 rounded-lg transition">Beranda</a>
      <a href="{{ route('detail.sampah') }}" class="hover:bg-[#334155] px-4 py-2 rounded-lg transition">Detail Sampah</a>
      <a href="{{ route('riwayat.sensor') }}" class="bg-[#334155] px-4 py-2 rounded-lg font-semibold transition">Riwayat Sensor</a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 p-6">
    <h1 class="text-3xl font-bold mb-6 text-center">📜 Riwayat Sensor</h1>

    <div class="overflow-x-auto rounded-lg shadow-lg">
      <table class="w-full text-sm text-left border-collapse bg-[#1e293b]" id="riwayatTable">
        <thead>
          <tr class="text-white border-b border-gray-600">
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Jenis</th>
            <th class="px-4 py-3">Kelembapan</th>
            <th class="px-4 py-3">Waktu</th>
          </tr>
        </thead>
        <tbody id="riwayatBody">
          <!-- Akan digantikan oleh JavaScript -->
        </tbody>
      </table>
    </div>
  </main>

  <script>
    async function loadRiwayat() {
      try {
        const res = await fetch('/api/waste-latest');
        const data = await res.json();
        const tbody = document.getElementById('riwayatBody');
        tbody.innerHTML = ''; // Kosongkan sebelum render ulang

        if (data.length === 0) {
          tbody.innerHTML = `
            <tr>
              <td colspan="4" class="text-center py-4 text-gray-400">Tidak ada data riwayat.</td>
            </tr>
          `;
          return;
        }

        data.forEach(item => {
          const row = document.createElement('tr');
          row.className = "hover:bg-[#334155] transition";

          row.innerHTML = `
            <td class="px-4 py-2 border-b border-gray-700">${item.id}</td>
            <td class="px-4 py-2 border-b border-gray-700 capitalize">${item.jenis}</td>
            <td class="px-4 py-2 border-b border-gray-700">${Math.round(item.kelembapan)}%</td>
            <td class="px-4 py-2 border-b border-gray-700">${item.created_at}</td>
          `;
          tbody.appendChild(row);
        });
      } catch (err) {
        console.error("Gagal mengambil data riwayat:", err);
      }
    }

    // Pertama kali load
    loadRiwayat();
    // Polling setiap 5 detik
    setInterval(loadRiwayat, 5000);
  </script>
</body>
</html>
