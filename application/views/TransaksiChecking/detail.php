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
        padding: 20px;
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

    .traffic-light {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .light {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: grey;
        border: 1px solid #aaa;
        transition: background-color 0.3s;
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

<div class="container mt-4">
    <?php if (!empty($layout)): ?>
        <h3>Detail Data Transaksi - <?= isset($line_name) ? 'LINE ' . strtoupper($line_name) : 'TIDAK DIKETAHUI' ?></h3>

        <?php
        // Grouping data defect
        $grouped = [];
        foreach ($operation_defects as $defect) {
            $group_key = $defect['op_code'] . '_' . $defect['id_transaksi_checking_detail'];
            $grouped[$group_key][] = $defect;
        }
        ?>

        <form method="post" action="<?= base_url('TransaksiChecking/detail'); ?>">
            <div class="grid-container">
                <?php foreach ($layout as $index => $item): ?>
                    <div class="card text-center shadow-sm card-operator">
                        <div class="card-body">
                            <div class="avatar-icon"><i class="fas fa-user-circle"></i></div>
                            <h5 class="card-title"><?= htmlspecialchars($item->op_name) ?></h5>
                            <p class="card-text"><strong>Operator:</strong> <?= htmlspecialchars($item->name ?? '-') ?></p>
                            <p class="card-text"><small>(<?= htmlspecialchars($item->op_code ?? 'TIDAK ADA KODE') ?>)</small></p>
                            <p class="card-text"><small><?= htmlspecialchars($item->machine_name ?? '-') ?></small></p>
                            <p class="card-text"><small>Total Defect: <?= $item->defect_count ?></small></p>

                            <div class="form-group">
                                <?php foreach ($operators as $op): ?>
                                    <?php if (
                                        isset($op->op_code, $item->op_code, $op->id_transaksi_checking_detail, $item->id_transaksi_checking_detail) &&
                                        trim((string)$op->op_code) === trim((string)$item->op_code) &&
                                        (string)$op->id_transaksi_checking_detail === (string)$item->id_transaksi_checking_detail
                                    ): ?>
                                        <p><?= htmlspecialchars($item->empID) ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#defectsModal<?= $index ?>">
                                Lihat Defect
                            </button>

                            <div class="modal fade" id="defectsModal<?= $index ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Daftar Defect</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $group_key = $item->op_code . '_' . $item->id_transaksi_checking_detail;
                                            if (isset($grouped[$group_key])): ?>
                                                <ul class="pl-3">
                                                    <?php foreach ($grouped[$group_key] as $d): ?>
                                                        <li>
                                                            <?= htmlspecialchars($d['deskripsi_defect']) ?> - Jumlah: <?= $d['jumlah'] ?>
                                                            <?= !empty($d['note']) ? ', Note: ' . htmlspecialchars($d['note']) : '' ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p class="text-muted">Tidak ada defect.</p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Traffic Light -->
                            <div class="traffic-light mt-2">
                                <?php
                                $group_key = $item->op_code . '_' . $item->id_transaksi_checking_detail;
                                $totalMajor = 0;
                                $totalMinor = 0;
                                $totalDefect = 0;

                                if (isset($grouped[$group_key])) {
                                    foreach ($grouped[$group_key] as $def) {
                                        $jumlah = (int) ($def['jumlah'] ?? 0);
                                        $kategori = strtolower($def['kategori_defect'] ?? '');
                                        $totalDefect += $jumlah;
                                        if ($kategori === 'major') {
                                            $totalMajor += $jumlah;
                                        } elseif ($kategori === 'minor') {
                                            $totalMinor += $jumlah;
                                        }
                                    }
                                }

                                $lightColor = 'green';
                                if ($totalDefect === 0) {
                                    $lightColor = 'green';
                                } elseif (($totalMajor >= 1 && $totalMinor >= 3) || $totalDefect >= 5) {
                                    $lightColor = 'red';
                                } elseif ($totalMajor >= 1) {
                                    $lightColor = 'red';
                                } elseif ($totalMinor <= 2 && $totalMajor === 0) {
                                    $lightColor = 'yellow';
                                } else {
                                    $lightColor = 'red';
                                }

                                echo '<span class="light ' . $lightColor . '"></span>';
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
