<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Report Harian - TLS</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h2>Report Harian Per Line</h2>

    <!-- Filter -->
    <form method="GET" action="">
        <label for="line">Pilih Line:</label>
        <select name="line_id" id="line">
            <option value="all">Semua Line</option>
            <option value="1">Line 1</option>
            <option value="2">Line 2</option>
            <!-- Tambahkan line lainnya -->
        </select>

        <label for="tanggal">Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" required>

        <button type="submit">Tampilkan</button>
    </form>

    <!-- Tabel Defect -->
    <table border="1" cellpadding="8" cellspacing="0" style="margin-top:20px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Operator</th>
                <th>Jenis Defect</th>
                <th>Kode Proses</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($report as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_operator'] ?></td>
                    <td><?= $row['jenis_defect'] ?></td>
                    <td><?= $row['kode_proses'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Grafik Pie Chart Jenis Defect -->
    <h3>Komposisi Jenis Defect</h3>
    <canvas id="pieChart" width="400" height="200"></canvas>

    <!-- Grafik Bar Chart Operator -->
    <h3>Jumlah Defect per Operator</h3>
    <canvas id="barChart" width="400" height="200"></canvas>

    <script>
        // Contoh dummy data - Ganti dengan data PHP dari controller
        const pieLabels = <?= json_encode($pie_labels) ?>;
        const pieData = <?= json_encode($pie_values) ?>;

        const barLabels = <?= json_encode($bar_labels) ?>;
        const barData = <?= json_encode($bar_values) ?>;

        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Jenis Defect',
                    data: pieData,
                    backgroundColor: ['#FF6384', '#FFCE56', '#36A2EB', '#8E44AD', '#2ECC71']
                }]
            }
        });

        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Jumlah Defect',
                    data: barData,
                    backgroundColor: '#3498DB'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>