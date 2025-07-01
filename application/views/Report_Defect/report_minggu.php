<div class="container p-5">
    <title>Report Mingguan</title>
    <h2 class="text-center mb-4">Report Mingguan</h2>
    <div class="row">
        <div class="col-md-4">
            <label>Line:</label>
            <select class="form-control" name="Workgroup" id="Workgroup" required>
                <option value="">-- Pilih Line --</option>
                <?php foreach ($line_list as $line): ?>
                    <option value="<?= $line['idWG']; ?>"><?= $line['Workgroup']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Style:</label>
            <select class="form-control" name="style" id="style" required>
                <option value="">-- Pilih Style --</option>
            </select>
        </div>
    </div>
</div>

<!-- Grafik -->
<div class="container mt-5">
    <canvas id="paretoChart" style="height: 400px; width: 100%;"></canvas>
</div>

<!-- Script Section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let paretoChart;
    const ctx = document.getElementById('paretoChart').getContext('2d');

    // Update Style dropdown berdasarkan Line
    $('#Workgroup').change(function() {
        const lineId = $(this).val();
        $('#style').empty().append('<option value="">-- Pilih Style --</option>');
        if (lineId !== '') {
            $.ajax({
                url: '<?= base_url("Report_Defect/getStyleByLine") ?>',
                method: 'POST',
                data: {
                    Workgroup: lineId
                },
                dataType: 'json',
                success: function(data) {
                    console.log("STYLE DATA:", data);
                    $.each(data, function(index, item) {
                        $('#style').append('<option value="' + item.id_operation_breakdown + '">' + item.style + ' | ' + item.date_created + '</option>');
                    });
                }
            });
        }
    });

    // Ambil data defect & update chart saat Style dipilih
    $('#style').change(function() {
        const lineId = $('#Workgroup').val();
        const opbId = $(this).val();
        if (lineId && opbId) {
            $.ajax({
                url: '<?= base_url("Report_Defect/getDefectChart") ?>',
                method: 'GET',
                data: {
                    line: lineId,
                    style: opbId
                },
                dataType: 'json',
                success: function(response) {
                    const labels = response.map(d => d.deskripsi_defect);
                    const data = response.map(d => parseInt(d.total));
                    const total = data.reduce((a, b) => a + b, 0);
                    let cumulative = 0;
                    const cumPercent = data.map(val => {
                        cumulative += val;
                        return ((cumulative / total) * 100).toFixed(2);
                    });
                    console.log("Response Data:", response);
                    const chartData = {
                        labels: labels,
                        datasets: [{
                                label: 'Jumlah Defect',
                                data: data,
                                backgroundColor: 'rgba(67, 0, 250, 0.28)',
                                yAxisID: 'y',
                            },
                            {
                                label: 'Kumulatif (%)',
                                data: cumPercent,
                                type: 'line',
                                borderColor: 'rgb(13, 20, 26)',
                                backgroundColor: 'rgba(54, 162, 235, 0.3)',
                                yAxisID: 'y1',
                                tension: 0.4,
                                fill: false,
                            }
                        ]
                    };

                    if (paretoChart) {
                        paretoChart.destroy();
                    }
                    paretoChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah Defect'
                                    }
                                },
                                y1: {
                                    beginAtZero: true,
                                    position: 'right',
                                    max: 100,
                                    ticks: {
                                        callback: value => value + '%'
                                    },
                                    grid: {
                                        drawOnChartArea: false
                                    },
                                    title: {
                                        display: true,
                                        text: 'Kumulatif (%)'
                                    }
                                }
                            }
                        }
                    });
                }
            });
        }
    });
</script>