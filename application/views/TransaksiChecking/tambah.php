<!-- <pre>
    <?php print_r($operators); ?>
</pre> -->
    <div class="container p-5">
    <h2>Tambah Data Input Defect</h2>
    <form method="post" action="<?= base_url('TransaksiChecking/simpan'); ?>">

        <div class="form-group">
            <label>Line</label>
            <input type="text" class="form-control" id="id_workgroup" value="<?= $line_name ?>" readonly>
        </div>

        <div class="form-group">
            <label>Style</label>
            <input type="text" class="form-control" id="id"  value="<?= $style_name ?>" readonly>

        </div>

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
            <label>Nama Proses</label>
            <select class="form-control" name="op_name" id="op_name" required>
                <option value="">-- Pilih Nama Proses --</option>
                <?php foreach ($operation_name as $on): ?>
                    <option 
                        value="<?= $on['op_name']; ?>" 
                        data-op-code="<?= htmlspecialchars($on['op_code']); ?>">
                        <?= $on['op_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

         <!-- Kode Proses (otomatis muncul)  -->
        <div class="form-group">
            <label>Kode Proses</label>
            <input type="text" class="form-control" name="op_code" id="op_code" readonly>
        </div>

        <!--Nama Defect -->
        <div class="form-group">
            <label>Nama Defect</label>
            <select class="form-control" name="deskripsi_defect" id="deskripsi_defect" required>
                <option value="">-- Pilih Nama Defect --</option>
                <?php foreach ($defect_list as $def): ?>
                    <option 
                        value="<?= $def['deskripsi_defect']; ?>" 
                        data-kode-defect="<?= htmlspecialchars($def['kode_defect']); ?>" 
                        data-kategori-defect="<?= htmlspecialchars($def['kategori_defect']); ?>">
                        <?= $def['deskripsi_defect']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Kode Defect (otomatis muncul) -->
        <div class="form-group">
            <label>Kode Defect</label>
            <input type="text" class="form-control" name="kode_defect" id="kode_defect" readonly>
        </div>

        <!-- Kategori Defect -->
        <div class="form-group">
            <label>Kategori Defect</label>
            <input type="text" class="form-control" name="kategori_defect" id="kategori_defect" readonly>
            <input type="hidden" name="kategori" id="kategori_input">
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="<?= base_url('TransaksiChecking'); ?>" class="btn btn-secondary mt-3">Kembali</a>
    </form>

            <script>
                    $(document).ready(function () {
                // Nama Proses otomatis
                $('#op_name').on('change', function () {
                    var kode = $(this).find(':selected').data('op-code');
                    $('#op_code').val(kode || '');
                });

                     $(document).ready(function () {
                    // Saat Nama Defect dipilih
                    $('#deskripsi_defect').on('change', function () {
                        var kodeDefect = $(this).find(':selected').data('kode-defect');
                        var kategori = $(this).find(':selected').data('kategori-defect');

                        $('#kode_defect').val(kodeDefect || '');
                        $('#kategori_defect').val(kategori || '');
                        $('#kategori_input').val(kategori || '');
                    });
                });

            });
        </script>
</div>
