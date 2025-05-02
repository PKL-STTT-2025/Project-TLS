<div class="container">

    <title>Input Defect</title>

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
            <h2>Daftar Input Defect</h2>
            <a href="<?= base_url(); ?>InputDefect/tambah" class="btn btn-primary">Tambah Data Input Defect</a>
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
                        <th scope="col">Kode Defect</th>
                        <th scope="col">Deskripsi Defect</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($InputDefect as $defect) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $defect['kode_defect']; ?></td>
                            <td><?= $defect['deskripsi_defect']; ?></td>
                            <td><?= $defect['kategori']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>InputDefect_Form/detail/<?= $defect['id']; ?>" class="btn btn-info">Detail</a>
                                <a href="<?= base_url(); ?>InputDefect_Form/ubah/<?= $defect['id']; ?>" class="btn btn-warning">Ubah</a>
                                <a href="<?= base_url(); ?>InputDefect_Form/hapus/<?= $defect['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</div>

