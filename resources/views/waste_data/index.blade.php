<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Data Sampah</title>
  <style>
    canvas {
      width: 100% !important;
      height: 100% !important;
    }
  </style>
</head>
<body class="bg-[#0f172a] text-white min-h-screen p-6">
  <div class="w-full max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-center mb-8">📊 Data Sampah</h1>

    <!-- TABEL -->
    <div class="overflow-x-auto rounded-lg shadow-lg mb-12">
      <table class="w-full text-sm text-left border-collapse">
        <thead class="bg-[#1e293b] text-white">
          <tr>
            <th class="px-4 py-3 border-b border-gray-600">ID</th>
            <th class="px-4 py-3 border-b border-gray-600">Jenis</th>
            <th class="px-4 py-3 border-b border-gray-600">Kelembapan</th>
            <th class="px-4 py-3 border-b border-gray-600">Waktu</th>
          </tr>
        </thead>
        <tbody>
          @php
            $latestTen = $wasteData->sortByDesc('created_at')->take(10);
          @endphp
          @forelse ($latestTen as $data)
          <tr class="hover:bg-[#334155] transition">
            <td class="px-4 py-2 border-b border-gray-700">{{ $data->id }}</td>
            <td class="px-4 py-2 border-b border-gray-700">{{ $data->jenis }}</td>
            <td class="px-4 py-2 border-b border-gray-700">{{ round($data->kelembapan) }}%</td>
            <td class="px-4 py-2 border-b border-gray-700">{{ $data->created_at }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-4 py-3 text-center text-gray-400">Tidak ada data tersedia.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- CHARTS + Total Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 items-start">
      <!-- Info Total -->
      <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg md:col-span-1">
        <h2 class="text-lg font-semibold mb-4">🔢 Total Data</h2>
        <p class="text-5xl font-bold text-green-400">{{ count($wasteData) }}</p>
        <p class="mt-2 text-gray-400">Data yang tersimpan di database.</p>
      </div>

      <!-- Diagram Batang -->
      <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg md:col-span-2 h-[300px]">
        <h2 class="text-xl font-semibold mb-4 text-center">Jumlah Jenis Sampah</h2>
        <canvas id="barChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Script -->
  <script>
    let wasteData = {!! json_encode($wasteData) !!};

    // Ambil 10 data terbaru
    wasteData = wasteData.sort((a, b) => new Date(b.created_at) - new Date(a.created_at)).slice(0, 10).reverse();

    const countDataByJenis = { kering: 0, basah: 0, logam: 0 };

    wasteData.forEach(item => {
      const jenis = item.jenis.toLowerCase();
      if (countDataByJenis[jenis] !== undefined) {
        countDataByJenis[jenis]++;
      }
    });

    // Bar Chart
    new Chart(document.getElementById("barChart"), {
      type: "bar",
      data: {
        labels: ["Kering", "Basah", "Logam"],
        datasets: [{
          label: 'Jumlah',
          data: [
            Math.round(countDataByJenis.kering),
            Math.round(countDataByJenis.basah),
            Math.round(countDataByJenis.logam)
          ],
          backgroundColor: [
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(234, 179, 8, 0.8)'
          ],
          borderColor: '#ffffff50',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              color: "white",
              precision: 0,
              callback: value => parseInt(value)
            }
          },
          x: { ticks: { color: "white" } }
        },
        plugins: {
          legend: { labels: { color: "white" } }
        }
      }
    });
  </script>
</body>
</html>
