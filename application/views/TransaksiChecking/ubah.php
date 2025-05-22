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
<h3>Ubah Data Input Defect - LINE <?= strtoupper($transaksi['Workgroup']) ?></h3>
    <form method="post" action="<?= base_url('TransaksiChecking/simpan'); ?>">

        <div class="grid-container">
            <?php foreach ($layouts as $layout_index => $layout): ?>
                <div class="card text-center shadow-sm card-operator">
                    <div class="card-body">
                        <div class="avatar-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>

                        <h5 class="card-title"><?= htmlspecialchars($layout->op_name) ?></h5>
                        <p class="card-text"><small>(<?= htmlspecialchars($layout->op_code) ?>)</small></p>
                        <p class="card-text"><small><?= htmlspecialchars($layout->nama_mesin) ?></small></p>

                        <!-- Hidden input yang perlu disimpan -->
                        <input type="hidden" name="id_workgroup[]" value="<?= $line ?>">
                        <input type="hidden" name="id_style[]" value="<?= $id_style ?>">
                        <input type="hidden" name="op_name[]" value="<?= $layout->op_name ?>">
                        <input type="hidden" name="op_code[]" value="<?= $layout->op_code ?>">
                        <!-- <input type="hidden" name="kategori_defect[]" value="<?= $layout->kategori_defect ?>"> -->

                        <!-- Dropdown Nama Operator -->
                        <div class="form-group">
                            <select class="form-control" name="empID[]" required>
                                <option value="">-- Pilih Nama Operator --</option>
                                <?php foreach ($operators as $op): ?>
                                    <option value="<?= $op['empID'] ?>"><?= $op['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Defect Group (bisa ditambah via JS) -->
                        <div class="defect-wrapper">
                            <div class="defect-group mb-2">
                                <div class="row">
                                    <div class="col-9">
                                    <!-- Change this in your view -->
                                        <select class="form-control" name="deskripsi_defect[<?= $layout_index ?>][]" required>
                                            <option value="">-- Pilih Nama Defect --</option>
                                            <?php foreach ($defect_list as $def): ?>
                                                <option 
                                                    value="<?= $def['deskripsi_defect']; ?>" 
                                                    data-kode-defect="<?= htmlspecialchars($def['kode_defect']); ?>" 
                                                    data-kategori-defect="<?= htmlspecialchars($def['kategori_defect']); ?>">
                                                    <?= $def['deskripsi_defect']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn text-danger remove-defect" style="font-size: 20px; font-weight: bold; line-height: 1;">×</button>
                                    </div>
                                </div>
                            </div>
                        </div>


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

        <button type="submit" name="aksi" value="simpan" class="btn btn-success mt-3">Simpan</button>
        <a href="<?= base_url('TransaksiChecking'); ?>" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.card-operator');

    cards.forEach((card, index) => {
        const addBtn = card.querySelector('.add-defect');
        const wrapper = card.querySelector('.defect-wrapper');

        addBtn.addEventListener('click', function () {
            const clone = wrapper.querySelector('.defect-group').cloneNode(true);
            const select = clone.querySelector('select');
            
            // Reset the select value
            select.selectedIndex = 0;
            
            // Ensure the name attribute is correct
            select.name = `deskripsi_defect[${index}][]`;
            
            wrapper.appendChild(clone);
        });
    });

    // Delegated event for remove buttons
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-defect')) {
            const group = e.target.closest('.defect-group');
            if (group && group.parentElement.querySelectorAll('.defect-group').length > 1) {
                group.remove();
            }
        }
    });
});
</script>

<script
  src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
  crossorigin="anonymous"
></script>
