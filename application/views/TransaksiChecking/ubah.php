<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Form Ubah Data
                </div>
                    <div class="card-body">
                        <form action="<?= base_url('TransaksiChecking/update/' . $transaksi_checking['id_transaksi_checking']); ?>" method="post">
                        <input type="hidden" name="id_transaksi_checking" value="<?= $transaksi_checking['id_transaksi_checking']; ?>">

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
                        <input type="text" class="form-control" id="op_code" readonly placeholder="Akan muncul otomatis">
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
                        <input type="text" class="form-control" id="kode_defect" readonly placeholder="Akan muncul otomatis">
                    </div>

                    <!-- Kategori Defect -->
                    <div class="form-group">
                        <label>Kategori Defect</label>
                        <input type="text" class="form-control" id="kategori_defect" readonly placeholder="Akan muncul otomatis">
                        <input type="hidden" name="kategori" id="kategori_input">
                    </div>
                            <button type="submit" name="ubah" class="btn btn-primary btn-sm">Ubah Data</button>
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
            </div>
        </div>
    </div>
</div>
