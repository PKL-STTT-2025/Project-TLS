<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Form Tambah Data Input Defect
                </div>
                <div class="card-body">
                <form action="<?= base_url('InputDefect/tambah'); ?>" method="post">
                        <div class="form-group">
                            <label for="kode_defect" class="form-label">Kode Defect</label>
                            <input type="text" class="form-control" id="kode_defect" name="kode_defect" readonly>
                            <small class="form-text text-danger"><?= form_error('kode_defect'); ?></small>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi_defect" class="form-label">Deskripsi Defect <span class="text-danger">*</span></label>
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
                            <small class="form-text text-muted">Pilih salah satu dari pilihan di atas</small>
                            <small class="form-text text-danger"><?= form_error('deskripsi_defect'); ?></small>
                        </div>

                        <div class="form-group">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" readonly>
                            <small class="form-text text-danger"><?= form_error('kategori'); ?></small>
                        </div>

                        <button type="submit" name="tambah" class="btn btn-primary">Tambah Data</button>
                    </form>
                        <script>
                            const deskripsiMap = {
                                1: { deskripsi: "1", kategori: "Minor" },
                                2: { deskripsi: "2", kategori: "Major" },
                                3: { deskripsi: "3", kategori: "Major" },
                                4: { deskripsi: "4", kategori: "Minor" },
                                5: { deskripsi: "5", kategori: "Major" },
                                6: { deskripsi: "6", kategori: "Major" },
                                7: { deskripsi: "7", kategori: "Minor" },
                                8: { deskripsi: "8", kategori: "Minor" },
                                9: { deskripsi: "9", kategori: "Minor" },
                                10: { deskripsi: "10", kategori: "Minor" },
                                11: { deskripsi: "11", kategori: "Major" },
                                12: { deskripsi: "12", kategori: "Major" },
                                13: { deskripsi: "13", kategori: "Minor" },
                                14: { deskripsi: "14", kategori: "Major" },
                                15: { deskripsi: "15", kategori: "Minor" },
                                16: { deskripsi: "16", kategori: "Minor" },
                                17: { deskripsi: "17", kategori: "Minor" },
                                18: { deskripsi: "18", kategori: "Major" },
                                19: { deskripsi: "19", kategori: "Minor" },
                                20: { deskripsi: "20", kategori: "Minor" },
                                21: { deskripsi: "21", kategori: "Minor" },
                                22: { deskripsi: "22", kategori: "Minor" }
                            };

                            document.getElementById('deskripsi_defect').addEventListener('change', function() {
                                const selected = this.value;
                                const def = deskripsiMap[selected];

                                if (def) {
                                    document.getElementById('kode_defect').value = def.deskripsi;
                                    document.getElementById('kategori').value = def.kategori;
                                } else {
                                    document.getElementById('kode_defect').value = '';
                                    document.getElementById('kategori').value = '';
                                }
                            });
                            document.getElementById('deskripsi_defect').dispatchEvent(new Event('change'));
                        </script>
                </div>
            </div>
        </div>
    </div>
</div>
