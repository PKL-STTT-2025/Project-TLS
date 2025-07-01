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

<div class="container mt-4">
    <h3>Data Operator per Line - LINE <?= strtoupper($line_name) ?></h3>
    <form method="post" action="<?= base_url('Supervisor/detail'); ?>">

        <div class="grid-container">
            <?php if (!empty($layouts)): ?>
                <?php foreach ($layouts as $item): ?>
                    <div class="card text-center shadow-sm card-operator">
                        <div class="card-body">
                            <div class="avatar-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>

                            <h5 class="card-title"><?= htmlspecialchars($item->op_name) ?></h5>
                            <p class="card-text"><small>(<?= htmlspecialchars($item->op_code) ?>)</small></p>
                            <p class="card-text"><small><?= htmlspecialchars($item->nama_mesin) ?></small></p>
                            <p class="card-text"><small>Total Defect: <?= ($item->defect_count) ?></small></p>

                            <!-- Tampilkan Nama Operator Langsung -->
                            <div class="form-group">
                                <?php foreach ($operators as $op): ?>
                                    <?php if (trim($op->op_code) === trim($item->op_code)): ?>
                                        <p><?= htmlspecialchars($op->operator_name) ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <!-- Tombol untuk membuka modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#defectsModal_<?= md5($item->op_name) ?>">
                                Lihat Defect
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="defectsModal_<?= md5($item->op_name) ?>" tabindex="-1" role="dialog" aria-labelledby="defectsModalLabel_<?= md5($item->op_name) ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="defectsModalLabel_<?= md5($item->op_name) ?>">Daftar Defect</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <?php
                                            // Filter defect sesuai op_name layout ini
                                            $filteredDefects = array_filter($operation_defects, function ($defect) use ($item) {
                                                return trim($defect['op_name']) === trim($item->op_name);
                                            });
                                            ?>

                                            <?php if (!empty($filteredDefects)): ?>
                                                <ul class="pl-3">
                                                    <?php foreach ($filteredDefects as $d): ?>
                                                        <li>
                                                            <?= htmlspecialchars($d['deskripsi_defect']) ?> -
                                                            Jumlah: <?= $d['jumlah'] ?><?= $d['note'] ? ', Note: ' . htmlspecialchars($d['note']) : '' ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p class="text-muted">Tidak ada defect yang tercatat.</p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


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
            <?php else: ?>
                <p class="text-center text-muted">Tidak ada data layout yang tersedia.</p>
            <?php endif; ?>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addButtons = document.querySelectorAll('.add-defect');

        addButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const parent = btn.closest('.card-body');
                const defectGroup = parent.querySelector('.defect-group');
                const clone = defectGroup.cloneNode(true);
                clone.querySelector('select').value = '';
                clone.querySelector('input').value = '';

                parent.insertBefore(clone, btn.parentElement);
            });
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-defect')) {
                const group = e.target.closest('.defect-group');
                const allGroups = group.parentElement.querySelectorAll('.defect-group');
                if (allGroups.length > 1) {
                    group.remove();
                }
            }
        });
    });
</script>

<a href="<?= base_url('Supervisor'); ?>" class="btn btn-secondary ml-4 mt-3 ">Kembali</a>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
    crossorigin="anonymous">
</script>