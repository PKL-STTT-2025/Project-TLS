<div class="container">
    <title>Master User</title>

    <?php if ($this->session->flashdata('flash')): ?>
        <div class="row mt-3">
            <div class="col-md-6" text-center>
                <div class="col md 6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data User <strong>berhasil</strong> <?= $this->session->flashdata('flash'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col-md-6">
            <h2>Daftar User</h2>
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
                        <th scope="col">id user</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NIK</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($master_user)) : ?>
                        <tr>

                        </tr>
                    <?php else : ?>
                        <?php $i = 1; ?>
                        <?php foreach ($master_user as $user) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $user['id_user']; ?></td>
                                <td><?= $user['nama']; ?></td>
                                <td><?= $user['NIK']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>