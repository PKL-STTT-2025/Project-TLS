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
                        <input type="hidden" name="id_workgroup" value="<?= $transaksi_checking['id_workgroup'] ?>">
                        <input type="hidden" name="id_style" value="<?= $transaksi_checking['id_style'] ?>">
                        <input type="hidden" name="employee_name" id="employee_name" value="<?= $transaksi_checking['employee_name'] ?>">
                        
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
                        <input type="text" class="form-control" id="op_code_display" readonly placeholder="Akan muncul otomatis">
                        <input type="hidden" name="op_code" id="op_code" value="<?= $transaksi_checking['op_code'] ?>">
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
                        <input type="text" class="form-control" id="kode_defect_display" readonly placeholder="Akan muncul otomatis">
                        <input type="hidden" name="kode_defect" id="kode_defect_input" value="<?= $transaksi_checking['kode_defect'] ?>">
                    </div>

                    <!-- Kategori Defect -->
                    <div class="form-group">
                        <label>Kategori Defect</label>
                        <input type="text" class="form-control" id="kategori_defect_display" readonly>
                        <input type="hidden" name="kategori_defect" id="kategori_defect" value="<?= $transaksi_checking['kategori_defect'] ?>">
                    </div>
                            <button type="submit" name="ubah" class="btn btn-primary btn-sm">Ubah Data</button>
                    </form>

                        <script>
                               $(document).ready(function() {
                                    // Set nilai awal dari data yang sudah ada
                                    $('#op_name').val('<?= $transaksi_checking['op_name'] ?>');
                                    $('#deskripsi_defect').val('<?= $transaksi_checking['deskripsi_defect'] ?>');
                                    
                                    // Update otomatis
                                    $('#op_name').on('change', function() {
                                        var kode = $(this).find(':selected').data('op-code');
                                        $('#op_code_input').val(kode || '');
                                        $('#op_code_display').val(kode || '');
                                    });

                                    $('#deskripsi_defect').on('change', function() {
                                        var kodeDefect = $(this).find(':selected').data('kode-defect');
                                        var kategori = $(this).find(':selected').data('kategori-defect');
                                        
                                        $('#kode_defect_input').val(kodeDefect || '');
                                        $('#kode_defect_display').val(kodeDefect);
                                        $('#kategori_defect').val(kategori || '');
                                        $('#kategori_defect_display').val(kategori || '');
                                    });
                                });
                        </script>
                </div>
            </div>
        </div>
    </div>
</div>
