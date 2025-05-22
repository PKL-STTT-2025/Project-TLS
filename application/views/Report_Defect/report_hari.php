<div class="container p-5">
    <title>Report Harian</title>
    <h2 class="text-center mb-4">Report Harian</h2>
    <form id="reportForm" method="post" action="<?= base_url('Report_Defect/reportHari'); ?>">
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

            <!-- jQuery AJAX -->
            <script>
                $(document).ready(function() {

                    $('#Workgroup').change(function() {
                        var line = $(this).val();
                        // console.log(line);

                        if (line != '') {
                            $.ajax({
                                url: "<?= base_url('Report_Defect/getStyleByLine'); ?>",
                                method: "POST",
                                data: {
                                    Workgroup: line
                                },
                                dataType: "json",
                                success: function(response) {
                                    // console.log(response)
                                    $("#style").empty();
                                    $("#style").append('<option value="">-- Pilih Style --</option>');

                                    $.each(response, function(index, item) {
                                        // console.log(index, item)
                                        $("#style").append('<option value="' + item.id_operation_breakdown + '">' + item.style + " | " + item.date_created + '</option>');
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.log("Error: " + xhr.responseText);
                                }
                            });
                        } else {
                            $('#style').empty();
                        }
                    });
                });
            </script>
            <div class="col-md-4 mt-4">
                <button type="button" class="btn btn-primary" id="searchBtn">Search</button>
            </div>
        </div> <!-- penutup .row -->
    </form>
</div>
</form>
</div>


<!-- Grafik -->
<div class="container" style="margin-top: 20px;">
    <canvas id="paretoChart" style="height: 300px; width: 100%;"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const defectData = <?php echo json_encode($defects); ?>;

    const labels = defectData.map(item => item.jenis_defect);
    const defectCounts = defectData.map(item => item.jumlah);

    const total = defectCounts.reduce((a, b) => a + b, 0);
    let cumulative = 0;
    const cumulativePercentage = defectCounts.map(count => {
        cumulative += count;
        return ((cumulative / total) * 100).toFixed(2);
    });

    const ctx = document.getElementById('paretoChart').getContext('2d');
    const paretoChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Jumlah Defect',
                    data: defectCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    yAxisID: 'y',
                },
                {
                    type: 'line',
                    label: 'Kumulatif (%)',
                    data: cumulativePercentage,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.3)',
                    yAxisID: 'y1',
                    tension: 0.4,
                    fill: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
                    min: 0,
                    max: 100,
                    ticks: {
                        callback: (value) => value + '%'
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
</script>