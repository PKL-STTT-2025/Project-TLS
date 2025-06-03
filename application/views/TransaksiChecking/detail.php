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

    .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        height: 420px;
        padding: 30px;
        text-align: center;
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
        gap: 5px;
        margin-top: 10px;
    }

    .light {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: grey;
        border: 1px solid #aaa;
    }

    .light.red {
        background-color: red;
    }

    .light.yellow {
        background-color: yellow;
    }

    .light.green {
        background-color: green;
    }
</style>

<<div class="container mt-4">
    <?php if (!empty($layout) && !empty($operators)): ?>
        <h3>Data Operator per Line - LINE <?= strtoupper($line_name) ?></h3>

        <form method="post" action="<?= base_url('TransaksiChecking/detail'); ?>">
            <div class="grid-container">
                <?php foreach ($layout as $index => $item): ?>
                    <div class="card text-center shadow-sm card-operator">
                        <div class="card-body">
                            <div class="avatar-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>

                            <h5 class="card-title"><?= htmlspecialchars($item->op_name) ?></h5>
                            <p class="card-text"><small>(<?= htmlspecialchars($item->op_code) ?>)</small></p>
                            <p class="card-text"><small><?= htmlspecialchars($item->nama_mesin) ?></small></p>
                            <p class="card-text"><small>Total Defect: <?= $item->defect_count ?></small></p>

                            <!-- Nama operator -->
                            <div class="form-group">
                                <?php foreach ($operators as $op): ?>
                                    <?php if (trim($op->op_code) === trim($item->op_code)): ?>
                                        <p><?= htmlspecialchars($op->operator_name) ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <!-- Tombol modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#defectsModal<?= $index ?>">
                                Lihat Defect
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="defectsModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="defectsModalLabel<?= $index ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="defectsModalLabel<?= $index ?>">Daftar Defect</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $found_defect = false;
                                            if (!empty($operation_defects)) {
                                                foreach ($operation_defects as $defect) {
                                                    if (trim($defect['op_name']) === trim($item->op_name)) {
                                                        $found_defect = true;
                                                        break;
                                                    }
                                                }
                                            }
                                            ?>

                                            <?php if ($found_defect): ?>
                                                <?php
                                                $grouped = [];
                                                foreach ($operation_defects as $defect) {
                                                    if (trim($defect['op_name']) === trim($item->op_name)) {
                                                        $grouped[$defect['op_name']][] = $defect;
                                                    }
                                                }
                                                ?>
                                                <?php foreach ($grouped as $op_name => $defects): ?>
                                                    <div class="mb-3">
                                                        <h6><strong><?= htmlspecialchars($op_name) ?></strong></h6>
                                                        <ul class="pl-3">
                                                            <?php foreach ($defects as $d): ?>
                                                                <li>
                                                                    <?= htmlspecialchars($d['deskripsi_defect']) ?> - 
                                                                    Jumlah: <?= $d['jumlah'] ?><?= $d['note'] ? ', Note: ' . htmlspecialchars($d['note']) : '' ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    <hr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p class="text-muted">Tidak ada defect untuk operator ini.</p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Traffic light -->
                            <div class="traffic-light mt-2">
                                <?php
                                $defect = $item->defect_count ?? 0;
                                if ($defect == 0) {
                                    $color = 'green';
                                } elseif ($defect == 1) {
                                    $color = 'yellow';
                                } else {
                                    $color = 'red';
                                }
                                echo '<span class="light ' . $color . '"></span>';
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    <?php else: ?>
        <p class="text-danger">Data transaksi tidak ditemukan.</p>
    <?php endif; ?>
</div>

<a href="<?= base_url('TransaksiChecking'); ?>" class="btn btn-secondary ml-4 mt-3">Kembali</a>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
    crossorigin="anonymous">
</script>
