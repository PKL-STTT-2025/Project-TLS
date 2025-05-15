<!-- <pre>
    <?php print_r($operators); ?>
</pre> -->
    <div class="container p-5">
    <h2>Tambah Data Input Defect</h2>
    <form method="post" action="<?= base_url('TransaksiChecking/simpan'); ?>">

        <!-- Nama Operator -->
        <div class="form-group">
            <label>Nama Operator</label>
            <select class="form-control" name="empID" required>
                <option value="">-- Pilih Nama Operator --</option>
                <?php foreach ($operators as $op): ?>
                    <option value="<?= $op['empID']; ?>"><?= $op['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Kode Proses + Nama Proses -->
        <div class="form-group">
            <label>Kode Proses</label>
            <select class="form-control" name="op_code" id="op_code" required>
                <option value="">-- Pilih Kode Proses --</option>
                <?php foreach ($operation_code as $oc): ?>
                    <option 
                        value="<?= $oc['op_code']; ?>" 
                        data-op-name="<?= htmlspecialchars($oc['op_name']); ?>">
                        <?= $oc['op_code']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

         <!-- Nama Proses (otomatis muncul)  -->
        <div class="form-group">
            <label>Nama Proses</label>
            <input type="text" class="form-control" id="op_name" readonly placeholder="Akan muncul otomatis">
        </div>

        <!-- Kode Defect -->
        <div class="form-group">
            <label>Kode Defect</label>
            <select class="form-control" name="kode_defect" id="kode_defect" required>
                <option value="">-- Pilih Kode Defect --</option>
                <?php foreach ($defect_list as $def): ?>
                    <option 
                        value="<?= $def['kode_defect']; ?>" 
                        data-defect-name="<?= htmlspecialchars($def['kode_defect']); ?>">
                        <?= $def['kode_defect']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Nama Defect (otomatis muncul) -->
        <div class="form-group">
            <label>Nama Defect</label>
            <input type="text" class="form-control" id="deskripsi_defect" readonly placeholder="Akan muncul otomatis">
        </div>

        <!-- Kategori Defect -->
        <div class="form-group">
            <label>Kategori Defect</label>
            <select class="form-control" name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Major">Major</option>
                <option value="Minor">Minor</option>
            </select>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="<?= base_url('TransaksiChecking'); ?>" class="btn btn-secondary mt-3">Kembali</a>
    </form>

            <script>
                    $(document).ready(function () {
                // Nama Proses otomatis
                $('#op_code').on('change', function () {
                    var nama = $(this).find(':selected').data('op-name');
                    $('#op_name').val(nama || '');
                });

                // Nama Defect otomatis
                $('#kode_defect').on('change', function () {
                    var defectName = $(this).find(':selected').data('deskripsi_defect');
                    $('#deskripsi_defect').val(defectName || '');
                });
            });
        </script>
</div>
