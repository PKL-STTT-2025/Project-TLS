<div class="container-fluid px-4 py-5">
    <h2 class="mb-4">Transaksi Checking</h2>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-warning text-black">
            <h5>Form Pemilihan Line, Style, Warna & ORC</h5>
        </div>
        <div class="card-body">
            <form id="selectionForm" method="get" action="<?= site_url('TransaksiChecking') ?>">
                <div class="row">
                    <!-- Line -->
                    <div class="col-md-3">
                        <label>Line:</label>
                        <select class="form-control" name="Workgroup" id="Workgroup" required>
                            <option value="">-- Pilih Line --</option>
                            <?php foreach ($line_list as $line): ?>
                                <option value="<?= $line['idWG']; ?>" 
                                    <?= ($this->input->get('Workgroup') == $line['idWG']) ? 'selected' : '' ?>>
                                    <?= $line['Workgroup']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Style -->
                    <div class="col-md-3">
                        <label>Style:</label>
                        <select class="form-control" name="style" id="style" required <?= empty($this->input->get('Workgroup')) ? 'disabled' : '' ?>>
                            <option value="">-- Pilih Style --</option>
                            <?php if(!empty($style_list)): ?>
                                <?php foreach ($style_list as $style): ?>
                                    <option value="<?= $style['id_operation_breakdown']; ?>" 
                                        <?= ($this->input->get('style') == $style['id_operation_breakdown']) ? 'selected' : '' ?>>
                                        <?= $style['style']; ?> (<?= date('d/m/Y', strtotime($style['date_created'])); ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Color -->
                    <div class="col-md-3">
                        <label>Color:</label>
                        <input type="text" class="form-control" id="color" name="color" value="<?= htmlspecialchars($this->input->get('color') ?? '') ?>">
                    </div>

                    <!-- ORC -->
                    <div class="col-md-3">
                        <label>ORC:</label>
                        <input type="text" class="form-control" id="orc" name="orc" value="<?= htmlspecialchars($this->input->get('orc') ?? '') ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if ($this->session->flashdata('flash')) : ?>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data Input Defect <strong><?= $this->session->flashdata('flash'); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Transaksi Checking</h2>
                <?php 
                    $workgroup = $this->input->get('Workgroup');
                    $style = $this->input->get('style');
                    $color = $this->input->get('color');
                    $orc = $this->input->get('orc');
                ?>
                <?php if($workgroup && $style): ?>
                    <button class="btn btn-success" id="btnAdd">
                        <i class="fas fa-plus"></i> Add Data
                    </button>
                <?php else: ?>
                    <button class="btn btn-secondary" disabled id="btnAdd">
                        <i class="fas fa-plus"></i> Add Data
                    </button>
                <?php endif; ?>
            </div>

            <form action="<?= base_url('TransaksiChecking/index') ?>" method="get" class="d-flex mt-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Search..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Line</th>
                                <th scope="col">Style</th>
                                <th scope="col">Color</th>
                                <th scope="col">ORC</th>
                                <th scope="col">Aksi</th>
                                <th scope="col">Masalah Selesai</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php if (!empty($TransaksiChecking)) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($TransaksiChecking as $transaksi) : ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $transaksi['line_name'] ?? '-' ?></td>
                                        <td><?= $transaksi['style'] ?? '-' ?></td>
                                        <td><?= $transaksi['color'] ?? '-' ?></td>
                                        <td><?= $transaksi['orc'] ?? '-' ?></td>
                                        <td>
                                            <a href="<?= base_url('TransaksiChecking/detail/'.$transaksi['id_transaksi_checking']) ?>" class="btn btn-sm btn-info">Detail</a>
                                            <a href="<?= base_url('TransaksiChecking/ubah/'.$transaksi['id_transaksi_checking']) ?>" class="btn btn-sm btn-warning">Ubah</a>
                                            <a href="<?= base_url('TransaksiChecking/hapus/'.$transaksi['id_transaksi_checking']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
                                        </td>
                                        <td><?= ($transaksi['masalah_selesai'] === '1') ? "Done" : "Not Done" ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data. Silakan pilih Line dan Style terlebih dahulu.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
$(document).ready(function() {
    // Load style berdasarkan line yang dipilih
    $('#Workgroup').change(function() {
        var lineId = $(this).val();
        var styleSelect = $('#style');
        
        if(lineId) {
            styleSelect.prop('disabled', false);
            $.ajax({
                url: "<?= base_url('TransaksiChecking/getStyleByLine') ?>",
                method: "POST",
                data: { Workgroup: lineId },
                dataType: "json",
                success: function(response) {
                    styleSelect.empty().append('<option value="">-- Pilih Style --</option>');
                    $.each(response, function(i, style) {
                        var dateCreated = new Date(style.date_created);
                        var formattedDate = dateCreated.getDate().toString().padStart(2, '0') + '/' + 
                                            (dateCreated.getMonth()+1).toString().padStart(2, '0') + '/' + 
                                            dateCreated.getFullYear();
                        
                        styleSelect.append(
                            '<option value="' + style.id + '">' + 
                            style.style + ' (' + formattedDate + ')' +
                            '</option>'
                        );
                    });
                    $('#selectionForm').submit();
                }
            });
        } else {
            styleSelect.empty().append('<option value="">-- Pilih Style --</option>').prop('disabled', true);
        }
    });

    // Submit form ketika style dipilih
    $('#style').change(function() {
        if($(this).val()) {
            $('#selectionForm').submit();
        }
    });
    $('#color').change(function() {
        $('#selectionForm').submit();
    });
    $('#orc').change(function() {
        $('#selectionForm').submit();
    });

    // Tambah tombol Add Data agar membawa color dan orc juga
    $('#btnAdd').click(function(e) {
        e.preventDefault();
        const line = $('#Workgroup').val();
        const style = $('#style').val();
        const color = $('#color').val();
        const orc = $('#orc').val();

        if (!line || !style) {
            alert('Harap pilih Line dan Style terlebih dahulu!');
            return;
        }

        const url = `<?= base_url('TransaksiChecking/tambah') ?>?Workgroup=${line}&style=${style}&color=${encodeURIComponent(color)}&orc=${encodeURIComponent(orc)}`;
        window.location.href = url;
    });
});
</script>
