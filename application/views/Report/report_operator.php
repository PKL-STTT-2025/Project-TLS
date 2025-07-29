<style>
    .card-body {
        padding: 1.5rem;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .fw-bold {
        font-weight: 600;
    }

    h2 {
        color: #000 !important;
    }

    /* Untuk semua judul dan heading */
    h1,
    h6,
    .card-header h6,
    .text-muted {
        color: #000 !important;
    }

    /* Label Defect Terbaru dan Info Operator */
    .card-body h6 {
        color: #000 !important;
    }

    /* Nama Operator, Mesin, Proses */
    .card-body h5,
    .card-body p,
    .card-body small {
        color: #000 !important;
    }

    .fw-bold,
    small {
        color: #000 !important;
    }
</style>
<div class="container p-5">
    <h1 class="text-left mb-4" style="color: #000;"><?= $title; ?></h1>

    <!-- Info Operator -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-4 align-items-center">
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Defect Terbaru</h6>
                    <div class="p-3 rounded bg-light border">
                        <?php if (!empty($latest_defect)) : ?>
                            <?php foreach ($latest_defect as $defect): ?>
                                <div class="fw-bold mb-1"><?= $defect->deskripsi_defect; ?> (<?= $defect->jumlah; ?>)</div>
                                <small class="text-muted">ID Transaksi: <?= $defect->id_transaksi_checking; ?></small>
                                <br>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div style="color: #000;">Tidak ada defect</div>
                        <?php endif; ?>
                    </div>

                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Info Operator</h6>
                    <div class="d-flex align-items-center p-1 bg-light border rounded" style="gap: 2rem;">
                        <div>
                            <i class="fas fa-user fa-5x text-secondary"></i>
                        </div>
                        <div class="ps-6">
                            <h5 class="mb-1"><?= $op->operator_name ?></h5>
                            <p class="mb-1"><small>(<?= $op->nama_mesin ?>)</small></p>
                            <p class="mb-1"><small>(<?= $op->kode_proses ?>)</small></p>
                            <?php
                            $status = strtolower($op->status ?? 'active');
                            $badgeClass = [
                                'active' => 'bg-success',
                            ][$status] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Histori Defect Operator -->
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Histori Defect Operator</h6>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row justify-content-center text-center">
                    <?php
                    $histori = $histori_defect;
                    if (empty($histori)) {
                        $total_kunjungan = isset($total_kunjungan) ? $total_kunjungan : 0;
                    ?>
                        <div class="row text-center mb-4">
                            <?php for ($i = 1; $i <= 12; $i++) :
                                $color = ($i <= $total_kunjungan) ? '#4caf50' : '#e0e0e0';
                            ?>
                                <div class="col-4 mb-3">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background-color: <?= $color ?>; display: flex; align-items: center; justify-content: center;font-weight: bold;">
                                        <?= $i ?>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="container text-center">
                            <div class="row">
                                <?php
                                foreach ($histori as $index => $row) {
                                    $nomor = $index + 1;
                                    $warna = 'gray';
                                    $textcolor = '#000';

                                    if ($row->jumlah == 0) $warna = '#4caf50';
                                    elseif ($row->jumlah == 1) $warna = 'yellow';
                                    elseif ($row->jumlah >= 2) $warna = 'red';
                                ?>
                                    <div class="col-4 mb-3">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background-color: <?= $warna ?>; color: <?= $textcolor ?>; display: flex; align-items: center; justify-content: center;font-weight: bold;">
                                            <?= $nomor ?>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <a href="<?= base_url('Report/index?id_wg=' . $op->id_wg . '&id_opb=' . $op->id_opb) ?>" class="btn btn-secondary ml-4 mt-3">Kembali</a>
</div>