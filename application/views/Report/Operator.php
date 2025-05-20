<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .content {
        flex: 1;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(5, minmax(180px, 1fr));
        gap: 20px;
        justify-items: center;
    }

    .card-operator {
        width: 100%;
        max-width: 180px;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        height: 220px;
        padding: 10px;
    }

    .card-title {
        font-size: 16px;
        margin-bottom: 4px;
    }

    .card-text {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 6px;
    }

    .badge {
        font-size: 12px;
    }

    .traffic-light {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 10px;
    }

    .light {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: grey;
        border: 1px solid #aaa;
    }

    .light.red {
        background-color: red;
    }

    .light.yellow {
        background-color: yellow;
    }

    .light.green {
        background-color: green;
    }
</style>
<div class="wrapper">
    <div class="content">
        <div class="container p-3">
            <title>Report operator</title>
            <form method="post" action="<?= base_url('ReportOperator/index'); ?>">
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
                    <script>
                        $(document).ready(function() {

                            $('#Workgroup').change(function() {
                                var line = $(this).val();
                                // console.log(line);

                                if (line != '') {
                                    $.ajax({
                                        url: "<?= base_url('ReportOperator/getStyleByLine'); ?>",
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
                </div>
                <div class="col-md-4 mt-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <div class="container mt-1">
            <h3 class="text-center mb-4"><?= $title ?> - LINE <?= strtoupper($line_name ?? '') ?></h3>
            <div class="grid-container">
                <?php if (!empty($operators)): ?>
                    <?php foreach ($operators as $op): ?>
                        <div class="card text-center shadow-sm card-operator">
                            <div class="card-body">
                                <i class="fas fa-user fa-2x mb-2 text-secondary"></i>
                                <a href="<?= base_url('ReportOperator/report_operator/' . $op->operator_name); ?>">
                                    <h5 class="card-title"><?= $op->operator_name ?></h5>
                                    <p class="card-text"><small>(<?= $op->nama_mesin ?>)</small></p>
                                    <p class="card-text"><small>(<?= $op->kode_proses ?>)</small></p>
                                </a>

                                <?php

                                // Simulasi status, ganti sesuai field dari database misal $op->status
                                $status = strtolower($op->status ?? 'active');
                                $badgeClass = [
                                    'active' => 'bg-success',
                                    'idle' => 'bg-warning',
                                    'error' => 'bg-danger'
                                ][$status] ?? 'bg-secondary';
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                <div class="mt-2">
                                    <?php
                                    $jumlah = isset($jumlah_kunjungan[$op->kode_proses]) ? $jumlah_kunjungan[$op->kode_proses] : 0;
                                    ?>
                                    <small> <?= $jumlah ?>x</small>
                                </div>
                                <!-- Traffic light -->
                                <div class="traffic-light mt-2">
                                    <?php
                                    $defect = isset($op->defect_count)
                                        ? $op->defect_count
                                        : rand(0, 10); // nilai acak antara 0-10S
                                    $color = 'green';
                                    if ($defect > 5) {
                                        $color = 'red';
                                    } elseif ($defect > 2) {
                                        $color = 'yellow';
                                    }
                                    echo '<span class="light ' . $color . '"></span>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Silakan pilih Line dan Style untuk melihat operator.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>




<!-- <script>
    $(document).ready(function() {
        $('#Workgroup').change(function() {
            var selectedLine = $(this).val();

            if (selectedLine !== '') {
                $.ajax({
                    url: "<?= base_url('ReportOperator/getStyleByLine'); ?>",
                    method: "POST",
                    data: {
                        Workgroup: line
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#style').html('<option value="">-- Pilih Style --</option>');
                        $.each(data, function(index, value) {
                            $('#style').append('<option value="' + value.style + '">' + value.style + '</option>');
                        });
                    }
                });
            } else {
                $('#style').html('<option value="">-- Pilih Style --</option>');
            }
        });
    });
</script> -->