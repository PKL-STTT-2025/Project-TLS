<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
        justify-items: center;
    }

    .card-operator {
        width: 100%;
        max-width: 240px;
    }

    .card {
    height: auto !important;
    display: flex;
    flex-direction: column;
    }

    .card-body {
    flex: 1 1 auto;
    overflow: visible;
    }


    .avatar-icon {
        font-size: 60px;
        color: #6c757d;
        margin-bottom: 15px;
    }

    .card-title {
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .card-text {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .form-group {
        width: 100%;
        margin-top: 10px;
    }

    select.form-control {
        font-size: 13px;
    }

    .traffic-light {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 15px;
    }

    .light {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: red;
        border: 2px solid #aaa;
    }
</style>

<div class="container mt-4">
    <?php if (isset($transaksi)): ?>
        <h3>Detail Transaksi - LINE <?= strtoupper($transaksi['Workgroup']) ?></h3>
        
        <!-- Header Info -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Style:</strong> <?= htmlspecialchars($transaksi['style']) ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Color:</strong> <?= htmlspecialchars($transaksi['color']) ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>ORC:</strong> <?= htmlspecialchars($transaksi['orc']) ?></p>
                    </div>
                    <!-- <div class="col-md-4">
                        <p><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($transaksi['date_created'])) ?></p>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="grid-container">
            <?php if (!empty($operations)): ?>
                <?php foreach ($operations as $op): ?>
                    <div class="card text-center shadow-sm card-operator">
                        <div class="card-body">
                            <div class="avatar-icon">
                            <i class="fas fa-user-circle"></i>
                            </div>

                            <h5 class="card-title"><?= htmlspecialchars($op['op_name']) ?></h5>
                            <p class="card-text"><small>(<?= htmlspecialchars($op['op_code']) ?>)</small></p>
                            <?php if (!empty($op['machine_name'])): ?>
                                <p class="card-text"><small><?= htmlspecialchars($op['machine_name']) ?></small></p>
                            <?php endif; ?>

                            <div class="defect-wrapper mt-3">
                                <?php if (!empty($op['defects'])): ?>
                                    <?php foreach ($op['defects'] as $defect): ?>
                                        <div class="defect-item mb-2 p-2 bg-light rounded">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <small class="text-muted"><?= htmlspecialchars($defect['deskripsi_defect']) ?></small>
                                                </div>
                                                <a href="<?= base_url('TransaksiChecking/detail_defect/'.$defect['id_transaksi_checking'].'/'.$defect['id_transaksi_checking']) ?>" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="alert alert-warning">Tidak ada defect</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">Tidak ada data operation</div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Data transaksi tidak ditemukan</div>
    <?php endif; ?>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="<?= base_url('TransaksiChecking') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>