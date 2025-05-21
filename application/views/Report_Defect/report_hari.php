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
    document.getElementById('searchBtn').addEventListener('click', function() {
        // Ambil nilai form
        const workgroup = document.getElementById('Workgroup').value;
        const style = document.getElementById('style').value;

        if (!workgroup || !style) {
            alert('Silakan pilih Line dan Style terlebih dahulu.');
            return;
        }

        // Simulasi data dummy berdasarkan pilihan (bisa diganti dengan AJAX ke server nantinya)
        const dummyData = [Math.floor(Math.random() * 20), 15, 9, 12, Math.floor(Math.random() * 20)];

        // Update chart
        chart.data.datasets[0].data = dummyData;
        chart.update();
    });
</script>

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
    // const barColors = defectData.map(() => 'rgba(52, 88, 150, 0.8)'); // biru navy transparan

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
                borderRadius: 2,
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