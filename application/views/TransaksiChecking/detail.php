<div class="container">
    <h3>Input Defect Detail</h3>
    <div class="row mt-3">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">Nama Operator : <?= $transaksi_checking['employee_name'] ?></li>
                <li class="list-group-item">Nama Proses : <?= $transaksi_checking['op_name'] ?></li>
                <li class="list-group-item">Kode Proses : <?= $transaksi_checking['op_code'] ?></li>
                <li class="list-group-item">Kode Defect : <?= $transaksi_checking['kode_defect'] ?></li>
                <li class="list-group-item">Deskripsi Defect : <?= $transaksi_checking['deskripsi_defect'] ?></li>
                <li class="list-group-item">Kategori : <?= $transaksi_checking['kategori_defect'] ?></li>
            </ul>
            <a href="<?= base_url(); ?>TransaksiChecking" class="btn btn-primary mt-3">Kembali</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>







