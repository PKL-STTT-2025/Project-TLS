<div class="container">
    <title>Daftar Operation Breakdown</title>

    <?php if ($this->session->flashdata('flash')) : ?>
        <div class="row mt-3">
            <div class="col-md-6 text-center">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Daftar Operation Breakdown <strong><?= $this->session->flashdata('flash'); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col-md-6">
            <h2>Daftar Operation Breakdown</h2>
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
                        <th>No</th>
                        <th>ID</th>
                        <th>Style</th>
                        <th>Date Ceated</th>
                        <th>ID User</th>
                        <th>ID Buyer</th>
                        <th>Front pic</th>
                        <th>Back pic</th>
                        <th>ID Line</th>
                        <th>Json layout</th>
                        <th>Pic layout</th>
                        <th>Parent Id</th>
                        <th>Master</th>
                        <th>Date Deleted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($operation_breakdown)) : ?>
                        <?php $i = 1; ?>
                        <?php foreach ($operation_breakdown as $opb) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $opb['id']; ?></td>
                                <td><?= $opb['style']; ?></td>
                                <td><?= $opb['date_created']; ?></td>
                                <td><?= $opb['id_user']; ?></td>
                                <td><?= $opb['id_buyer']; ?></td>
                                <td><?= $opb['front_pic']; ?></td>
                                <td><?= $opb['back_pic']; ?></td>
                                <td><?= $opb['id_line']; ?></td>
                                <td><?= $opb['json_layout']; ?></td>
                                <td><?= $opb['pic_layout']; ?></td>
                                <td><?= $opb['parent_id']; ?></td>
                                <td><?= $opb['master']; ?></td>
                                <td><?= $opb['date_deleted']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data Operation Breakdown.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>