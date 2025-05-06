<!-- Begin Page Content -->
<div class="container-fluid">

    <h4>Master Defect</h4>
    <form method="post" action="<?= base_url('master_defect/index'); ?>">
        <div class="form-group mb-3">
            <label>User:</label>
            <input type="text" class="form-control" name="user" value="<?= $nama_user ?>" readonly>
        </div>

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

            <div class="col-md-4">
                <label>ORC:</label>
                <<select class="form-control" name="orc" id="orc" required>
                    <option value="">-- Pilih ORC --</option>
                    <?php foreach ($orc_list as $orc): ?>
                        <option value="<?= $orc['orc']; ?>"><?= $orc['orc']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        </br>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="row mt-3">
        <div class="col md 6">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Defect</th>
                        <th scope="col">Deskripsi Defect</th>
                        <th scope="col">Kategori</th>
                    </tr>
                </thead>
                <?php if (!empty($list_transaksi)) : ?>
                        <?php foreach ($list_transaksi as $defect) : ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data jenis barang.</td>
                        </tr>
                    <?php endif; ?>

                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($list_transaksi as $defect) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $defect['kode_defect']; ?></td>
                            <td><?= $defect['deskripsi_defect']; ?></td>
                            <td><?= $defect['kategori']; ?></td>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#Workgroup').change(function() {
            var id_line = $(this).val();

            if (id_line != '') {
                $.ajax({
                    url: "<?= base_url('transaksi_checking/get_layout_by_Workgroup'); ?>",
                    method: "POST",
                    data: {
                        Workgroup: id_line
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#style').val(response.data.style || '');
                            $('#orc').val(response.data.orc || '');
                        } else {
                            $('#style').val('');
                            $('#orc').val('');
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + xhr.responseText);
                    }
                });
            } else {
                $('#style').val('');
                $('#orc').val('');
            }
        });
    });
</script>