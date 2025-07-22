<style>
    .container-fluid {
  padding-left: 30px;
  padding-right: 30px;
}

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

<div class="container-fluid mt-4">
    <h3>Data Operator per Line - LINE <?= strtoupper($line_name) ?></h3>
    <h4>Total <span class="text-danger"><?= strtoupper($jumlah_proses) ?></span> proses</h4>

    <form method="post" action="<?= base_url('TransaksiChecking/simpan'); ?>">

        <div class="row">
            <?php foreach ($layouts as $layout_index => $layout): ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">

                            <div class="avatar-icon mb-2">
                                <i class="fas fa-user-circle fa-3x"></i>
                            </div>

                            <h5 class="card-title"><?= htmlspecialchars($layout->op_name ?? '') ?></h5>
                            <p class="card-text">
                                <small>(<?= htmlspecialchars($layout->op_code ?? '') ?>)</small><br>
                                <small><?= htmlspecialchars($layout->machine_name ?? '') ?></small>
                            </p>

                            <input type="hidden" name="id_wg" value="<?= htmlspecialchars($line ?? '') ?>">
                            <input type="hidden" name="id_opb" value="<?= htmlspecialchars($id_style ?? '') ?>">
                            <input type="hidden" name="color" value="<?= htmlspecialchars($this->input->get('color') ?? '') ?>">
                            <input type="hidden" name="orc" value="<?= htmlspecialchars($this->input->get('orc') ?? '') ?>">

                            <input type="hidden" name="id_master_opt_layout[]" value="<?= htmlspecialchars($layout->id_master_opt_layout ?? '') ?>">
                            <input type="hidden" name="op_name[]" value="<?= htmlspecialchars($layout->op_name ?? '') ?>">
                            <input type="hidden" name="op_code[]" value="<?= htmlspecialchars($layout->op_code ?? '') ?>">
                            <input type="hidden" name="id_jnsbarang[]" value="<?= htmlspecialchars($layout->id_jnsbarang ?? '') ?>">

                            
                                <div class="form-group mt-2">
                                    <label><?= $layout->op_name; ?></label>
                                    <select name="empID[<?= $layout->id_master_opt_layout; ?>]" class="form-control" required>
                                        <?php foreach ($operators as $op): ?>
                                            <option value="<?= $op['empID']; ?>"
                                                <?= (
                                                    isset($layout->default_operator) &&
                                                    is_object($layout->default_operator) &&
                                                    $op['empID'] == $layout->default_operator->empID
                                                ) ? 'selected' : ''; ?>>
                                                <?= $op['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                           


                            <div class="defect-wrapper">
                                <div class="defect-group mb-2">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <select class="form-control" name="deskripsi_defect[<?= $layout_index ?>][]" required>
                                                <option value="">-- Pilih Nama Defect --</option>
                                                <?php foreach ($defect_list as $def): ?>
                                                    <option value="<?= $def['deskripsi_defect']; ?>">
                                                        <?= $def['deskripsi_defect']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="jumlah[<?= $layout_index ?>][]" class="form-control" placeholder="Jumlah" required>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" name="catatan[<?= $layout_index ?>][]" class="form-control" placeholder="Catatan">
                                        </div>
                                        <div class="col-1 d-flex align-items-center">
                                            <button type="button" class="btn text-danger remove-defect" style="font-size: 20px;">×</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Tambah -->
                            <div class="text-center mt-2">
                                <button type="button" class="btn btn-primary btn-sm add-defect">+ Tambah Defect</button>
                            </div>

                            <!-- Traffic Light -->
                            <div class="traffic-light mt-3">
                                <span class="light" style="background-color: green; width: 20px; height: 20px; display: inline-block; border-radius: 50%;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-4">
            <button type="submit" name="aksi" value="simpan" class="btn btn-success">Simpan</button>
            <a href="<?= base_url('TransaksiChecking'); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<!-- Inline CSS -->
<style>
    .defect-group input, .defect-group select {
        font-size: 0.9rem;
    }
    .defect-group .form-control {
        padding: 0.25rem 0.5rem;
    }
    .card-title {
        font-size: 1.1rem;
        font-weight: bold;
    }
    .traffic-light .light {
        transition: background-color 0.3s;
    }
</style>

<!-- Script Defect & Traffic Light -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-defect').forEach((button, layoutIndex) => {
        button.setAttribute('data-layout-index', layoutIndex);

        button.addEventListener('click', function () {
            const layoutIndex = this.getAttribute('data-layout-index');
            const container = this.closest('.card-body').querySelector('.defect-wrapper');

            const defectHTML = `
                <div class="defect-group mb-2">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <select class="form-control" name="deskripsi_defect[${layoutIndex}][]" required>
                                <option value="">-- Pilih Nama Defect --</option>
                                ${getDefectOptions()}
                            </select>
                        </div>
                        <div class="col-2">
                            <input type="number" class="form-control" name="jumlah[${layoutIndex}][]" placeholder="Jumlah" min="1" required />
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" name="catatan[${layoutIndex}][]" placeholder="Catatan">
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <button type="button" class="btn text-danger remove-defect" style="font-size: 20px;">×</button>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', defectHTML);
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-defect')) {
            const cardBody = e.target.closest('.card-body');
            e.target.closest('.defect-group').remove();
            updateTrafficLight(cardBody);
        }
    });

    document.querySelectorAll('.card-body').forEach(cardBody => {
        cardBody.addEventListener('change', function (e) {
            if (e.target.matches('input[type="number"], select[name^="deskripsi_defect"]')) {
                updateTrafficLight(cardBody);
            }
        });
    });

    function getDefectOptions() {
        const defectList = <?= json_encode($defect_list) ?>;
        return defectList.map(def =>
            `<option value="${def.deskripsi_defect}" data-kategori-defect="${def.kategori_defect}">${def.deskripsi_defect}</option>`
        ).join('');
    }

    function updateTrafficLight(cardBody) {
        let totalDefect = 0;
        const defectGroups = cardBody.querySelectorAll('.defect-group');

        defectGroups.forEach(group => {
            const jumlahInput = group.querySelector('input[name^="jumlah"]');
            const jumlah = parseInt(jumlahInput?.value) || 0;
            totalDefect += jumlah;
        });

        const light = cardBody.querySelector('.traffic-light .light');

        if (light) {
            if (totalDefect === 0) {
                light.style.backgroundColor = 'green';
            } else if (totalDefect === 1 || totalDefect === 2) {
                light.style.backgroundColor = 'yellow';
            } else {
                light.style.backgroundColor = 'red';
            }
        }
    }
});
</script>


