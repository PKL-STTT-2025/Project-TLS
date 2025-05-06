<div class="container">

    <title>Transaksi Checking</title>

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
                        <th scope="col">No</th>
                        <th scope="col">Kode Proses</th>
                        <th scope="col">Nama Operator</th>
                        <th scope="col">Jenis Defect</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <?php if (!empty($transaksi_checking)) : ?>
                        <?php foreach ($transaksi_checking as $transaksi) : ?>
                        <?php endforeach; ?>
                <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data.</td>
                        </tr>
                    <?php endif; ?>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($transaksi_checking as $transaksi) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $transaksi['op_code']; ?></td>
                            <td><?= $transaksi['employee_name']; ?></td>
                            <td><?= $transaksi['ada_defect']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>transaksi_checking/detail/<?= $transaksi['id']; ?>" class="btn btn-info">Detail</a>
                                <a href="<?= base_url(); ?>transaksi_checking/ubah/<?= $transaksi['id']; ?>" class="btn btn-warning">Ubah</a>
                                <a href="<?= base_url(); ?>transaksi_checkingq/hapus/<?= $transaksi['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</div>

