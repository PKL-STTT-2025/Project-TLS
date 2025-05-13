<div class="container">
    <title>Daftar Karyawan</title>

    <?php if ($this->session->flashdata('flash')) : ?>
        <div class="row mt-3">
            <div class="col-md-6 text-center">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Daftar Karyawan <strong><?= $this->session->flashdata('flash'); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col-md-6">
            <h2>Daftar Karyawan</h2>
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
                        <th>EmpID</th>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Gender</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mstemp)) : ?>
                        <?php $i = 1; ?>
                        <?php foreach ($mstemp as $emp) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $emp['empID']; ?></td>
                                <td><?= $emp['NIK']; ?></td>
                                <td><?= $emp['name']; ?></td>
                                <td><?= $emp['gender']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data Karyawan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>