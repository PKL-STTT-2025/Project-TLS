<style>
    /* Judul */
    h2 {
        color: #000 !important;
    }

    /* Input search */
    form input[type="text"]::placeholder,
    form input[type="text"] {
        color: #000 !important;
    }

    /* Teks di tabel */
    table td,
    table th {
        color: #000 !important;
    }

    .table thead th {
        text-align: center;
        vertical-align: middle !important;
    }
</style>

<div class="container p-5">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>GI-TLS List Checking Time</h2>
            </div>

            <form action="<?= base_url('Supervisor/index') ?>" method="get" class="d-flex mt-3">
                <input type="text" name="keyword" value="<?= $this->input->get('keyword'); ?>" class="form-control me-2" placeholder="Search..." aria-label="Search">
                <button class="btn btn-outline-success ml-4" type="submit">Search</button>
            </form>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Line</th>
                                    <th>Style</th>
                                    <th>ORC</th>
                                    <th>Aksi</th>
                                    <th>Masalah Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($CheckingTime)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($CheckingTime as $CT) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $CT['line_name'] ?? '-' ?></td>
                                            <td><?= $CT['style'] ?? '-' ?></td>
                                            <td><?= $CT['kode_orc'] ?? '-' ?></td>
                                            <td>
                                                <a href="<?= base_url('Supervisor/detail/' . $CT['id_transaksi_checking']) ?>" class="btn btn sm btn-info btn-sm me-1 mb-1">Detail</a>
                                                <a href="<?= base_url('Supervisor/action_plan/' . $CT['id_transaksi_checking']) ?>" class="btn btn sm btn-warning btn-sm me-1 mb-1">Action Plan</a>
                                                <a href="<?= base_url('Supervisor/hapus/' . $CT['id_transaksi_checking']) ?>" class="btn btn sm btn-danger btn-sm me-1 mb-1" onclick="return confirm('Yakin?');">Hapus</a>
                                            </td>
                                            <td class="status-selesai text-center">
                                                <?= $CT['masalah_selesai'] == 1 ? '✔️' : '' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Belum ada data.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>