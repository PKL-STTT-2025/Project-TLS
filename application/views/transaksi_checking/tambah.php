<div class="container">
    <div class="row at mt-3">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    Form Tambah Input Defect
                </div>
                <div class="card-body">
                <form action="" method="post">
                <div class="col-md-12">
                    <label>Kode Proses</label>
                    <select class="form-control" name="operation_code" id="operation_code" required>
                        <option value="">-- Pilih Kode Proses --</option>
                        <?php foreach ($op_code as $operation): ?>
                            <option value="<?= $operation['op_code']; ?>"><?= $operation['op_code']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <!-- <div class="form-group">
                    <label for="deskripsi_defect">Deskripsi Defect</label>
                    <input type="text" name="deskripsi_defect" class="form-control" id="deskripsi_defect">
                    <small class="form-text text-danger"><?= form_error('deskripsi_defect');?></small>
                  </div> -->

            <div class="card-body">
            <form action="<?= base_url('transaksi_checking/tambah'); ?>" method="post">
                <div class="form-group">
                    <label for="kode_defect" class="form-label">Kode Defect</label>
                        <select class="form-control" id="kode_defect" name="kode_defect">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>    
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                        </select>
                    <small class="form-text text-danger"><?= form_error('kode_defect'); ?></small>
                </div>

                <div>
                    <form action="<?= base_url('transaksi_checking/tambah'); ?>" method="post">
                        <div class="form-group">
                            <label for="deskripsi_defect" class="form-label">Deskripsi Defect</label>
                                <select class="form-control" id="deskripsi_defect" name="deskripsi_defect">
                                    <option value="1">Dirty/Soil/Kotor</option>
                                    <option value="2">Cut/Hole/tergunting</option>
                                    <option value="3">Broken stitch/putus</option>
                                    <option value="4">Skip stitch/loncat</option>
                                    <option value="5">Incorrect stitching/salah jumlah stitching</option>
                                    <option value="6">Not caught/jebol/tidak terjahit</option>
                                    <option value="7">Too loose/ terlalu kendor</option>
                                    <option value="8">Too tight/terlalu kencang</option>
                                    <option value="9">Puckering/ Gelombang</option>
                                    <option value="10">Pleated/ terlipat</option>
                                    <option value="11">Unconsistance measurement/ukuran panjang pendek</option>
                                    <option value="12">Wrong size/ salah size</option>
                                    <option value="13">Visible single needle/jarum satu kelihatan</option>
                                    <option value="14">Unbalance/ tidak sama/tidak sejajar</option>
                                    <option value="15">Wire play to much/ wire play kepanjangan</option>
                                    <option value="16">No wire play/wire play tidak ada</option>
                                    <option value="17">Slanting/Miring</option>
                                    <option value="18">Missing operation/ operation kurang</option>
                                    <option value="19">Long Thread/ buang benang tidak bersih</option>
                                    <option value="20">Needle hole/ bekas jarum</option>
                                    <option value="21">Overlap</option>
                                    <option value="22">Bubbling</option>
                                </select>
                    <small class="form-text text-danger"><?= form_error('deskripsi_defect'); ?></small>
                </div>

            
            <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" id="kategori"name="kategori">
                        <option value="major"> Major</option>
                        <option value="minor"> Minor</option>
                        <small class="form-text text-danger"><?= form_error('kategori'); ?></small>
                    </select>
            </div>
        
            </div>
                <button type="submit" name="tambah"class="btn btn-primary btn-sm">Tambah Data</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>
        
        
