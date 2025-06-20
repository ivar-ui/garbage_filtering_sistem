<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Data Sampah</title>
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
      <a href="{{ route('data.sampah') }}" class="bg-[#334155] px-4 py-2 rounded-lg font-semibold transition">Beranda</a>
      <a href="{{ route('detail.sampah') }}" class="hover:bg-[#334155] px-4 py-2 rounded-lg transition">Detail Sampah</a>
      <a href="{{ route('riwayat.sensor') }}" class="hover:bg-[#334155] px-4 py-2 rounded-lg transition">Riwayat Sensor</a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 p-6">
    <h1 class="text-3xl font-bold text-center mb-8">Data Sampah</h1>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
      <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-lg font-semibold mb-2">Total Data</h2>
        <p class="text-5xl font-bold text-green-400" id="totalData">0</p>
        <p class="text-gray-400 text-sm mt-2">Data tersimpan</p>
      </div>
      <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-lg font-semibold mb-2">Sampah Kering</h2>
        <p class="text-5xl font-bold text-blue-400" id="jumlahKering">0</p>
        <p class="text-gray-400 text-sm mt-2">Jumlah data kering</p>
      </div>
      <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-lg font-semibold mb-2">Sampah Basah</h2>
        <p class="text-5xl font-bold text-emerald-400" id="jumlahBasah">0</p>
        <p class="text-gray-400 text-sm mt-2">Jumlah data basah</p>
      </div>
      <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-lg font-semibold mb-2">Sampah Logam</h2>
        <p class="text-5xl font-bold text-yellow-400" id="jumlahLogam">0</p>
        <p class="text-gray-400 text-sm mt-2">Jumlah data logam</p>
      </div>
    </div>

    <!-- CHART -->
    <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg h-[300px]">
      <h2 class="text-xl font-semibold mb-4 text-center">Diagram Jumlah Jenis Sampah</h2>
      <canvas id="barChart"></canvas>
    </div>
  </main>

  <!-- CHART SCRIPT -->
  <script>
    const ctx = document.getElementById("barChart").getContext("2d");

    const chart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Kering", "Basah", "Logam"],
        datasets: [{
          label: "Jumlah",
          data: [0, 0, 0],
          backgroundColor: [
            "rgba(59, 130, 246, 0.8)",
            "rgba(16, 185, 129, 0.8)",
            "rgba(234, 179, 8, 0.8)"
          ],
          borderColor: "#ffffff50",
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: { color: "white", precision: 0 }
          },
          x: {
            ticks: { color: "white" }
          }
        },
        plugins: {
          legend: { labels: { color: "white" } }
        }
      }
    });

    function updateData(data) {
      let kering = 0, basah = 0, logam = 0;
      data.forEach(item => {
        switch (item.jenis.toLowerCase()) {
          case 'kering': kering++; break;
          case 'basah': basah++; break;
          case 'logam': logam++; break;
        }
      });

      chart.data.datasets[0].data = [kering, basah, logam];
      chart.update();

      document.getElementById("totalData").textContent = data.length;
      document.getElementById("jumlahKering").textContent = kering;
      document.getElementById("jumlahBasah").textContent = basah;
      document.getElementById("jumlahLogam").textContent = logam;
    }

    async function fetchData() {
      const res = await fetch("/api/waste-latest");
      const json = await res.json();
      updateData(json);
    }

    // Inisialisasi awal
    fetchData();

    // Polling setiap 5 detik
    setInterval(fetchData, 5000);
  </script>
</body>
</html>
