<div class="container">
    <title>Jenis Barang</title>

    <?php if ($this->session->flashdata('flash')) : ?>
        <div class="row mt-3">
            <div class="col md 6 text-center">
                <div class="col md 6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data Jenis Barang <strong><?= $this->session->flashdata('flash'); ?></strong>
                        <button type="button" classs="btn-close" data-bs-dismiss="alert" aria-table='close' aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col md 6">
            <h2>Daftar Jenis Barang</h2>
            
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
                        <th scope="col">Kode Jenis Barang</th>
                        <th scope="col">Nama Jenis Barang</th>
                    </tr>
                </thead>
                <?php if (!empty($jns_barang)) : ?>
                        <?php foreach ($jns_barang as $barang) : ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data jenis barang.</td>
                        </tr>
                    <?php endif; ?>

                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($jns_barang as $barang) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $barang['id_jnsbarang']; ?></td>
                            <td><?= $barang['name']; ?></td>
                            <td>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>