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
</style>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Info Operator -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-4 align-items-center">
                <!-- KIRI: Defect Terbaru -->
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Defect Terbaru</h6>
                    <div class="p-3 rounded bg-light border">
                        <?php if (!empty($latest_defect)) : ?>
                            <div class="fw-bold mb-1"><?= $latest_defect->deskripsi_defect; ?></div>
                            <small class="text-muted">ID Transaksi: <?= $latest_defect->id_transaksi_checking; ?></small>
                        <?php else : ?>
                            <div class="text-muted">Tidak ada defect</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- KANAN: Info Operator -->
                <div class="col-md-6 d-flex align-items-center">
                    <div class="me-9">
                        <i class="fas fa-user fa-5x text-secondary"></i>
                    </div>
                    <div>
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




    <!-- Histori Defect Operator -->
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Histori Defect Operator</h6>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row justify-content-center text-center">
                    <?php
                    $histori = $this->Dashboard_model->get_defect_operator();
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
                                    $textcolor = '#00000';
                                    if ($row['ada_defect'] == 0) $warna = '#4caf50';
                                    elseif ($row['ada_defect'] == 1) $warna = 'yellow';
                                    elseif ($row['ada_defect'] == 2) $warna = 'red';
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
</div>