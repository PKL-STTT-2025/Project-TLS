<div class="container p-5">
    <title>Transaksi Checking</title>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-warning text-black">
            <h5>Pilih Line dan Style</h5>
        </div>
        <div class="card-body">
            <form id="selectionForm" method="get" action="<?= site_url('TransaksiChecking') ?>">
                <div class="row">
                    <div class="col-md-4">
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

                    <div class="col-md-4">
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
                <?php if($this->input->get('Workgroup') && $this->input->get('style')): ?>
                    <a href="<?= base_url('TransaksiChecking/tambah?Workgroup='.$this->input->get('Workgroup').'&style='.$this->input->get('style')) ?>" 
                       class="btn btn-success" id="btnAdd">
                       <i class="fas fa-plus"></i> Add Data
                    </a>
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
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Line</th>
                        <th>Style</th>
                        <th>Nama Operator</th>
                        <th>Kode Proses</th>
                        <th>Nama Proses</th>
                        <th>Kode Defect</th>
                        <th>Deskripsi Defect</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                        <th>Masalah Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($TransaksiChecking)) : ?>
                        <?php $i = 1; ?>
                        <?php foreach ($TransaksiChecking as $transaksi) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $transaksi['id_workgroup'] ?? '-' ?></td>
                                <td><?= $transaksi['id_style'] ?? '-' ?></td>
                                <td><?= $transaksi['employee_name'] ?? '-' ?></td>
                                <td><?= $transaksi['op_code'] ?? '-' ?></td>
                                <td><?= $transaksi['op_name'] ?? '-' ?></td>
                                <td><?= $transaksi['kode_defect'] ?? '-' ?></td>
                                <td><?= $transaksi['deskripsi_defect'] ?? '-' ?></td>
                                <td><?= $transaksi['kategori_defect'] ?? '-' ?></td>
                                <td>
                                    <a href="<?= base_url('TransaksiChecking/detail/'.$transaksi['id_transaksi_checking']) ?>" class="btn btn sm btn-info">Detail</a>
                                    <a href="<?= base_url('TransaksiChecking/ubah/'.$transaksi['id_transaksi_checking']) ?>" class="btn btn sm btn-warning">Ubah</a>
                                    <a href="<?= base_url('TransaksiChecking/hapus/'.$transaksi['id_transaksi_checking']) ?>" class="btn btn sm btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
                                </td>
                                <td><?= ($transaksi['masalah_selesai'] === '1') ? "Done" : "Not Done" ?></td>
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
        
        if(lineId) {
            // Enable dropdown style
            styleSelect.prop('disabled', false);
            
            // Load via AJAX
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
        if($(this).val()) {
            $('#selectionForm').submit();
        }
    });
});
</script>