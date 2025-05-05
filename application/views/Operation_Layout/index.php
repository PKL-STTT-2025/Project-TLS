<div class="container">
    <title>Operation Layout</title>

    <?php if ($this->session->flashdata('flash')) : ?>
        <div class="row mt-3">
            <div class="col md 6 text-center">
                <div class="col md 6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Alur Proses <strong><?= $this->session->flashdata('flash'); ?></strong>
                        <button type="button" classs="btn-close" data-bs-dismiss="alert" aria-table='close' aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col md 6">
            <h2>Alur Proses Sewing</h2>
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
                        <th scope="col">Nama Proses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($master_opt_layout as $operation) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $operation['op_code']; ?></td>
                            <td><?= $operation['op_name']; ?></td>
                            <td>
                               
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>    
            </table>
        </div>
    </div>
</div>