<style>
    /* Judul */
    h2 {
        color: #000 !important;
    }

    /* Teks di tabel */
    table td,
    table th {
        color: #000 !important;
    }

    .table thead th {
        text-align: center;
        vertical-align: middle !important;
    }

    /* Teks dropdown Line dan Style */
    select.form-control,
    select {
        color: #000 !important;
    }

    /* Label Line dan Style */
    label,
    .form-label,
    .col-form-label {
        color: #000 !important;
    }
</style>
<div class="container p-5">
    <h2 class="text-left mb-4">GI-TLS Report Operator</h2>
    <div class="row">
        <div class="col-md-4">
            <label>Line:</label>
            <select class="form-control" name="Workgroup" id="Workgroup" required>
                <option value="">-- Pilih Line --</option>
                <?php foreach ($line_list as $line): ?>
                    <option value="<?= $line['idWG']; ?>" <?= ($selected_wg == $line['idWG']) ? 'selected' : '' ?>>
                        <?= $line['Workgroup']; ?>
                    </option>
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
    <div class="row mt-5">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Proses</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyReportIndex">
                    <?php if (!empty($reportoperator)): ?>
                        <?php foreach ($reportoperator as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= $item['nama_proses']; ?></td>
                                <td>
                                    <?php if (!empty($item['id_transaksi_checking_detail'])): ?>
                                        <a href="<?= base_url('Report/report_operator/' . $item['id_transaksi_checking_detail']) ?>" class="btn btn-sm btn-info">Detail</a>
                                    <?php else: ?>
                                        <span class="text-muted">Belum dicek</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Silakan pilih Line dan Style.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Script Section -->
<script>
    // Update Style dropdown berdasarkan Line
    $('#Workgroup').change(function() {
        const lineId = $(this).val();
        $('#style').empty().append('<option value="">-- Pilih Style --</option>');
        if (lineId !== '') {
            $.ajax({
                url: '<?= base_url("Report/getStyleByLine") ?>',
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

    // Ambil data proses berdasarkan Line dan Style
    $('#style, #Workgroup').on('change', function() {
        var id_opb = $('#style').val();
        var id_wg = $('#Workgroup').val();

        if (id_opb && id_wg) {
            $.ajax({
                url: '<?= base_url('Report/getReportIndex') ?>',
                type: 'POST',
                data: {
                    id_opb: id_opb,
                    id_wg: id_wg
                },
                dataType: 'json',
                success: function(response) {
                    let html = '';
                    if (response.length > 0) {
                        response.forEach(function(item, index) {
                            html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.nama_proses}</td>`;

                            if (item.id_transaksi_checking_detail) {
                                html += `<td><a href="<?= base_url('Report/report_operator/') ?>${item.id_transaksi_checking_detail}" class="btn btn-sm btn-info">Detail</a></td>`;
                            } else {
                                html += `<td><span class="text-muted">Belum dicek</span></td>`;
                            }

                            html += `</tr>`;
                        });

                    } else {
                        html = `
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada proses ditemukan.</td>
                            </tr>`;
                    }
                    $('#tbodyReportIndex').html(html);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        }
    });
</script>