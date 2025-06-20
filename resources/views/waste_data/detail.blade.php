<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Detail Sampah</title>
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
      <a href="{{ route('detail.sampah') }}" class="bg-[#334155] px-4 py-2 rounded-lg font-semibold transition">Detail Sampah</a>
      <a href="{{ route('riwayat.sensor') }}" class="hover:bg-[#334155] px-4 py-2 rounded-lg transition">Riwayat Sensor</a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="flex-1 p-6">
    <h1 class="text-3xl font-bold mb-6 text-center">📈 Grafik Kelembapan Sampah</h1>

    <!-- DOWNLOAD BUTTON -->
    <div class="mb-6 flex justify-end">
      <a href="{{ route('export.excel') }}" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-lg font-medium text-white transition">
        Unduh Excel
      </a>
    </div>

    <!-- LINE CHART -->
    <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg">
      <canvas id="lineChart" height="200"></canvas>
    </div>
  </main>

  <!-- CHART SCRIPT -->
  <script>
    const ctx = document.getElementById('lineChart').getContext('2d');
    let chart;

    function renderChart(wasteData) {
      const labels = wasteData.map((_, index) => `Data ke-${index + 1}`);
      const dataPoints = wasteData.map(item => item.kelembapan);

      if (chart) {
        chart.data.labels = labels;
        chart.data.datasets[0].data = dataPoints;
        chart.update();
        return;
      }

      chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Kelembapan (%)',
            data: dataPoints,
            borderColor: 'rgba(59, 130, 246, 1)',
            backgroundColor: 'rgba(59, 130, 246, 0.2)',
            tension: 0.5,
            fill: true,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: 'white',
            pointBorderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          animation: {
            duration: 1500,
            easing: 'easeOutQuart'
          },
          scales: {
            x: {
              ticks: { color: 'white' },
              grid: { color: '#334155' }
            },
            y: {
              beginAtZero: true,
              ticks: { color: 'white' },
              grid: { color: '#334155' }
            }
          },
          plugins: {
            legend: {
              labels: { color: 'white' }
            },
            tooltip: {
              mode: 'index',
              intersect: false,
              backgroundColor: '#1e293b',
              titleColor: '#ffffff',
              bodyColor: '#ffffff',
              borderColor: '#4ade80',
              borderWidth: 1
            }
          },
          interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
          }
        }
      });
    }

    async function fetchAndUpdate() {
      try {
        const res = await fetch('/api/waste-latest');
        const data = await res.json();
        renderChart(data);
      } catch (err) {
        console.error("Gagal memuat data:", err);
      }
    }

    // Pertama kali render
    fetchAndUpdate();
    // Polling setiap 5 detik
    setInterval(fetchAndUpdate, 5000);
  </script>
</body>
</html>
