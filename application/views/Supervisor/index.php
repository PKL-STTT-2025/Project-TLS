<div class="container p-5">
    <title>List Checking Time</title>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>


    <div class="row mt-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>List Checking Time</h2>
            </div>

            <form action="<?= base_url('Supervisor/index') ?>" method="get" class="d-flex mt-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Search..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Line</th>
                                <th>Style</th>
                                <th>Nama Proses</th>
                                <th>Aksi</th>
                                <th>Masalah Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($CheckingTime)) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($CheckingTime as $CT) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $CT['line_name'] ?? '-' ?></td>
                                        <td><?= $CT['style'] ?? '-' ?></td>
                                        <td><?= $CT['nama_proses'] ?? '-' ?></td>
                                        <td>
                                            <a href="<?= base_url('Supervisor/detail/' . $CT['id_transaksi_checking']) ?>" class="btn btn sm btn-info">Detail</a>
                                            <a href="<?= base_url('Supervisor/action_plan/' . $CT['id_transaksi_checking']) ?>" class="btn btn sm btn-warning">Action Plan</a>
                                            <a href="<?= base_url('Supervisor/hapus/' . $CT['id_transaksi_checking']) ?>" class="btn btn sm btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data. Silakan pilih Line dan Style terlebih dahulu.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Load style berdasarkan line yang dipilih
                $('#Workgroup').change(function() {
                    var lineId = $(this).val();
                    var styleSelect = $('#style');

                    if (lineId) {
                        // Enable dropdown style
                        styleSelect.prop('disabled', false);

                        // Load via AJAX
                        $.ajax({
                            url: "<?= base_url('TransaksiChecking/getStyleByLine') ?>",
                            method: "POST",
                            data: {
                                Workgroup: lineId
                            },
                            dataType: "json",
                            success: function(response) {
                                styleSelect.empty().append('<option value="">-- Pilih Style --</option>');
                                $.each(response, function(i, style) {
                                    var dateCreated = new Date(style.date_created);
                                    var formattedDate = dateCreated.getDate().toString().padStart(2, '0') + '/' +
                                        (dateCreated.getMonth() + 1).toString().padStart(2, '0') + '/' +
                                        dateCreated.getFullYear();

                                    styleSelect.append(
                                        '<option value="' + style.id + '">' +
                                        style.style + ' (' + formattedDate + ')' +
                                        '</option>'
                                    );
                                });

                                // Submit form setelah load style
                                $('#selectionForm').submit();
                            }
                        });
                    } else {
                        // Reset jika line tidak dipilih
                        styleSelect.empty().append('<option value="">-- Pilih Style --</option>').prop('disabled', true);
                    }
                });

                // Submit form ketika style dipilih
                $('#style').change(function() {
                    if ($(this).val()) {
                        $('#selectionForm').submit();
                    }
                });
            });
        </script>
    </div>
</div>