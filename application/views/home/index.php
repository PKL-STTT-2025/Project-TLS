<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard QC Inline</title>
  <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <h1>Dashboard QC Inline</h1>

  <div class="operator-card">
    <h2>Operator: <?= $nama ?></h2>
    <p>Mesin: Single Needle</p>
    <div class="status green">Status: Hijau</div>
  </div>

  <div class="chart-container">
    <canvas id="todayChart"></canvas>
    <canvas id="weekChart"></canvas>
    <canvas id="monthChart"></canvas>
  </div>

  <script>
    const dataToday = <?= $today ?>;
    const dataWeek = <?= $week ?>;
    const dataMonth = <?= $month ?>;

    function renderChart(id, title, value) {
      new Chart(document.getElementById(id), {
        type: 'doughnut',
        data: {
          labels: ['Defect', 'OK'],
          datasets: [{
            label: title,
            data: [value, 100 - value],
            backgroundColor: ['#ff6384', '#36a2eb']
          }]
        },
        options: {
          plugins: {
            title: {
              display: true,
              text: title
            }
          }
        }
      });
    }

    renderChart("todayChart", "Hari Ini", dataToday);
    renderChart("weekChart", "Minggu Ini", dataWeek);
    renderChart("monthChart", "Bulan Ini", dataMonth);
  </script>
</body>
</html>
<h1>Hello, <?= $nama; ?>!</h1>
