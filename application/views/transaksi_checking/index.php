<div class="container">

    <title>Transaksi Checking</title>
    <form method="post" action="<?= base_url('transaksi_checking/index'); ?>">
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
        </div>
        </br>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if ($this->session->flashdata('flash')) : ?>
        <div class="row mt-3">
            <div class="col md 6 text-center">
            <div class="col md 6">
                <div class="alert alert-success alert-dismissible fade show" role ="alert">
                    Data Input Defect <strong ><?= $this->session ->flashdata('flash'); ?></strong>
                    <button type= "button" classs="btn-close" data-bs-dismiss="alert" aria-table ='close' aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col md 6">
            <h2>Transaksi Checking</h2>
            <a href="<?= base_url(); ?>transaksi_checking/tambah" class="btn btn-primary">Tambah Data Input Defect</a>
            <form action="" method="post" class="d-flex mt-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Search..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col md 6">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>ID Layout</th>
                    <th>User</th>
                    <th>Op Code</th>
                    <th>Op Name</th>
                    <th>Employee</th>
                    <th>Machine</th>
                    <th>Ada Defect</th>
                    <th>Masalah Selesai</th>
                    </tr>
                </thead>
                <?php if (!empty($transaksi_checking)) : ?>
                        <?php foreach ($transaksi_checking as $transaksi) : ?>
                        <?php endforeach; ?>
                <?php else : ?>
                        <tr>
                            <td colspan="10" class="text-center">Belum ada data.</td>
                        </tr>
                    <?php endif; ?>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($transaksi_checking as $transaksi) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $transaksi['line_list']; ?></td>
                            <td><?= $transaksi['style_list']; ?></td>
                                <a href="<?= base_url(); ?>transaksi_checking/detail/<?= $transaksi['id']; ?>" class="btn btn-info">Detail</a>
                                <a href="<?= base_url(); ?>transaksi_checking/ubah/<?= $transaksi['id']; ?>" class="btn btn-warning">Ubah</a>
                                <a href="<?= base_url(); ?>transaksi_checking/hapus/<?= $transaksi['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</div>

