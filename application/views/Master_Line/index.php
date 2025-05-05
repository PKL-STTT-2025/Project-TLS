<div class="container">
    <title>Master Line</title>

    <?php if ($this->session->flashdata('flash')): ?>
        <div class="row mt-3">
            <div class="col-md-6" text-center>
                <div class="col md 6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data Line <strong>berhasil</strong> <?= $this->session->flashdata('flash'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col-md-6">
            <h2>Daftar Line</h2>
            <form action="" method="post" class="d-flex mt-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Search..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Line Name</th>
                        <th scope="col">SPV</th>
                    </tr>
                </thead>
                <?php if (empty($master_line)) : ?>
                    <?php foreach ($master_line as $line) : ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>

                    </tr>
                <?php endif; ?>

                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($master_line as $line) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $line['line_name']; ?></td>
                            <td><?= $line['spv']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>