<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Ubah Data Input Defect
                </div>
                <div class="card-body">
                    <form action="<?= base_url('InputDefect/ubah/'.$InputDefect['id']); ?>" method="post">
                        <input type="hidden" name="id" value="<?= $InputDefect['id']; ?>">

                        <div class="form-group">
                            <label for="kode_defect" class="form-label">Kode Defect</label>
                            <input type="text" class="form-control" id="kode_defect" name="kode_defect" value="<?= $InputDefect['kode_defect']; ?>" readonly>
                            <small class="form-text text-danger"><?= form_error('kode_defect'); ?></small>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi_defect" class="form-label">Deskripsi Defect <span class="text-danger">*</span></label>
                            <select class="form-control" id="deskripsi_defect" name="deskripsi_defect">
                                <option value=""> Pilih Deskripsi </option>
                                <?php
                                $deskripsiDefects = [
                                    1 => "Dirty/Soil/Kotor",
                                    2 => "Cut/Hole/tergunting",
                                    3 => "Broken stitch/putus",
                                    4 => "Skip stitch/loncat",
                                    5 => "Incorrect stitching/salah jumlah stitching",
                                    6 => "Not caught/jebol/tidak terjahit",
                                    7 => "Too loose/ terlalu kendor",
                                    8 => "Too tight/terlalu kencang",
                                    9 => "Puckering/ Gelombang",
                                    10 => "Pleated/ terlipat",
                                    11 => "Unconsistance measurement/ukuran panjang pendek",
                                    12 => "Wrong size/ salah size",
                                    13 => "Visible single needle/jarum satu kelihatan",
                                    14 => "Unbalance/ tidak sama/tidak sejajar",
                                    15 => "Wire play to much/ wire play kepanjangan",
                                    16 => "No wire play/wire play tidak ada",
                                    17 => "Slanting/Miring",
                                    18 => "Missing operation/ operation kurang",
                                    19 => "Long Thread/ buang benang tidak bersih",
                                    20 => "Needle hole/ bekas jarum",
                                    21 => "Overlap",
                                    22 => "Bubbling"
                                ];
                                foreach ($deskripsiDefects as $key => $desc) {
                                    $selected = ($key == $InputDefect['deskripsi_defect']) ? 'selected' : '';
                                    echo "<option value=\"$key\" $selected>$desc</option>";
                                }
                                ?>
                            </select>
                            <small class="form-text text-muted">Pilih salah satu dari pilihan di atas</small>
                            <small class="form-text text-danger"><?= form_error('deskripsi_defect'); ?></small>
                        </div>

                        <div class="form-group">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" value="<?= $InputDefect['kategori']; ?>" readonly>
                            <small class="form-text text-danger"><?= form_error('kategori'); ?></small>
                        </div>

                        <button type="submit" name="ubah" class="btn btn-primary">Ubah Data</button>
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
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
