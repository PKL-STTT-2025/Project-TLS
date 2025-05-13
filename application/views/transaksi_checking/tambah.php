<div class="container">

    <div class="row at mt-3">
        <div class="col-md-6">

                    <div class="card">
                <div class="card-header">
                    Form Tambah Input Defect
                </div>
                <div class="card-body">
                <form action="" method="post">
            <div class="form-group">
                    <label for="kode_defect">Kode Defect</label>
                    <input type="text" name="kode_defect" class="form-control" id="kode_defect">
                    <small class="form-text text-danger"><?= form_error ('kode_defect');?></small>
                  </div>
            <div class="form-group">
                    <label for="deskripsi_defect">Deskripsi Defect</label>
                    <input type="text" name="deskripsi_defect" class="form-control" id="deskripsi_defect">
                    <small class="form-text text-danger"><?= form_error('deskripsi_defect');?></small>
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
        
        
