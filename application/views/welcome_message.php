<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - Traffic Light System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: rgb(148, 163, 212);
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .charts {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .chart-container {
            width: 300px;
            margin-bottom: 30px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <h2>Welcome to QC Traffic Light System</h2>

        <div class="charts">
            <div class="chart-container">
                <h4>Hari Ini</h4>
                <canvas id="chartHari"></canvas>
            </div>
            <div class="chart-container">
                <h4>Minggu Ini</h4>
                <canvas id="chartMinggu"></canvas>
            </div>
            <div class="chart-container">
                <h4>Bulan Ini</h4>
                <canvas id="chartBulan"></canvas>
            </div>
        </div>
    </div>

    <script>
        const dataHari = {
            labels: ['Hijau', 'Kuning', 'Merah'],
            datasets: [{
                data: [70, 20, 10],
                backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
            }]
        };

        const dataMinggu = {
            labels: ['Hijau', 'Kuning', 'Merah'],
            datasets: [{
                data: [60, 30, 10],
                backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
            }]
        };

        const dataBulan = {
            labels: ['Hijau', 'Kuning', 'Merah'],
            datasets: [{
                data: [65, 25, 10],
                backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
            }]
        };

        const configHari = {
            type: 'pie',
            data: dataHari,
        };

        const configMinggu = {
            type: 'pie',
            data: dataMinggu,
        };

        const configBulan = {
            type: 'pie',
            data: dataBulan,
        };

        new Chart(document.getElementById('chartHari'), configHari);
        new Chart(document.getElementById('chartMinggu'), configMinggu);
        new Chart(document.getElementById('chartBulan'), configBulan);
    </script>
</body>

</html>