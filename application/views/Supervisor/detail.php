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
    <h3>Data Operator per Line - LINE <?= strtoupper($line_name) ?></h3>
    <form method="post" action="<?= base_url('Supervisor/detail'); ?>">

        <div class="grid-container">
            <?php foreach ($layouts as $layout): ?>
                <div class="card text-center shadow-sm card-operator">
                    <div class="card-body">
                        <div class="avatar-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>

                        <h5 class="card-title"><?= htmlspecialchars($layout->op_name) ?></h5>
                        <p class="card-text"><small>(<?= htmlspecialchars($layout->op_code) ?>)</small></p>
                        <p class="card-text"><small><?= htmlspecialchars($layout->nama_mesin) ?></small></p>

                        <!-- Dropdown Nama Operator -->
                        <div class="form-group">
                            <select class="form-control" name="empID[]" required>
                                <option value="">-- Pilih Nama Operator --</option>
                                <?php foreach ($operators as $op): ?>
                                    <option value="<?= $op['empID'] ?>"><?= $op['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Dropdown Nama Defect -->
                        <div class="defect-group mb-2">
                            <div class="row">
                                <div class="col-7">
                                    <select class="form-control" name="defect[][deskripsi_defect]" required>
                                        <option value="">-- Defect --</option>
                                        <?php foreach ($defect_list as $def): ?>
                                            <option value="<?= htmlspecialchars($def['deskripsi_defect']); ?>">
                                                <?= htmlspecialchars($def['deskripsi_defect']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <input type="number" name="defect[][jumlah_defect]" min="1" value="1" class="form-control" required>
                                </div>

                                <div class="col-2">
                                    <button type="button" class="btn text-danger remove-defect" style="font-size: 20px; font-weight: bold; line-height: 1;">×</button>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol tambah defect -->
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-primary btn-sm add-defect">+ Tambah Defect</button>
                        </div>


                        <div class="traffic-light">
                            <span class="light" style="background-color: red;"></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
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


<button type="submit" name="aksi" value="simpan" class="btn btn-success mt-3">Simpan</button>
<a href="<?= base_url('TransaksiChecking'); ?>" class="btn btn-secondary mt-3">Kembali</a>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
    crossorigin="anonymous">
</script>