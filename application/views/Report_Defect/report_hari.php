<div class="container p-5">
    <title>Report Harian</title>
    <form method="post" action="<?= base_url('Report_Defect/reportHari'); ?>">
        <div class="row">
            <div class="col-md-4">
                <label>Line:</label>
                <select class="form-control" name="Workgroup" id="Workgroup" required>
                    <option value="">-- Pilih Line --</option>
                    <?php foreach ($line_list as $line): ?>
                        <option value="<?= $line['Workgroup']; ?>"><?= $line['Workgroup']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label>Style:</label>
                <select class="form-control" name="style" id="style" required>
                    <option value="">-- Pilih Style --</option>
                    <?php foreach ($style_list as $style): ?>
                        <option value="<?= $style['style']; ?>"><?= $style['style']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 mt-4">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
</div>



<!-- Grafik -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="card-body">
            <div class="chart-bar" style="height:300px;">
                <canvas id="chartHarian"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('chartHarian').getContext('2d');

    // Data jumlah defect per hari (contoh, nanti tinggal replace dari PHP/JSON/AJAX)
    const defectData = [12, 19, 7, 15, 10];

    // Function generate warna random dalam range RGB yang diinginkan
    function getRandomColor(minR, maxR, minG, maxG, minB, maxB) {
        const r = Math.floor(Math.random() * (maxR - minR + 1)) + minR;
        const g = Math.floor(Math.random() * (maxG - minG + 1)) + minG;
        const b = Math.floor(Math.random() * (maxB - minB + 1)) + minB;
        return `rgba(${r}, ${g}, ${b}, 0.8)`;
    }

    // Buat array warna sesuai data
    const barColors = defectData.map(value => {
        if (value >= 15) {
            // Merah range
            return getRandomColor(200, 255, 0, 70, 0, 70);
        } else if (value >= 8) {
            // Kuning range
            return getRandomColor(200, 255, 200, 255, 0, 70);
        } else {
            // Hijau range
            return getRandomColor(0, 70, 200, 255, 0, 70);
        }
    });

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
            datasets: [{
                label: 'Jumlah Defect',
                data: defectData,
                backgroundColor: barColors,
                borderColor: 'rgba(0,0,0,0.1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>