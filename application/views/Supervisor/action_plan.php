<style>
    .error-border {
        border: 2px solid red;
    }

    .error-message {
        color: red;
        font-size: 0.85rem;
        margin-top: 4px;
    }
</style>

<div class="container p-3 p-md-5">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>List Action Plan</h2>
            </div>

            <form action="<?= base_url('Supervisor/action_plan') ?>" method="get" class="d-flex mt-3">
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
                                    <th>Nama Defect</th>
                                    <th>Jumlah Defect</th>
                                    <th>Action Plan</th>
                                    <th>Catatan</th>
                                    <th>Act</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($ActionPlan)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($ActionPlan as $AP) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $AP->deskripsi_defect ?? '-' ?></td>
                                            <td><?= $AP->jumlah ?? '-' ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action Plan
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#" onclick="setActionPlan(this)">Technical</a>
                                                        <a class="dropdown-item" href="#" onclick="setActionPlan(this)">Mekanik</a>
                                                    </div>
                                                </div>
                                                <script>
                                                    function setActionPlan(el) {

                                                        const button = el.closest('.btn-group').querySelector('.btn');
                                                        button.textContent = el.textContent;
                                                    }
                                                </script>
                                                <input type="hidden" name="action_plan" value="">
                                            </td>
                                            <td>
                                                <textarea name="catatan[]" class="form-control" rows="2" placeholder="Tulis catatan..."></textarea>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" onclick="submitBarisIni(this)">Go</button>
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
<div class="mt-4">
    <a href="<?= base_url('Supervisor/selesai/') ?>" class="btn btn-success">Selesai</a>
    <a href="<?= base_url('Supervisor'); ?>" class="btn btn-secondary">Kembali</a>
</div>
<script>
    function setActionPlan(el) {
        const dropdown = el.closest('.btn-group');
        const button = dropdown.querySelector('.btn');
        const hiddenInput = dropdown.parentElement.querySelector('input[name="action_plan"]');

        button.textContent = el.textContent;
        hiddenInput.value = el.textContent;
    }

    function submitBarisIni(button) {
        const row = button.closest('tr');

        const namaDefect = row.querySelector('td:nth-child(2)').innerText.trim();
        const jumlahDefect = row.querySelector('td:nth-child(3)').innerText.trim();
        const actionPlan = row.querySelector('input[name="action_plan"]').value.trim();
        const catatanEl = row.querySelector('textarea[name="catatan[]"]');
        const catatan = catatanEl.value.trim();
        const dropdownButton = row.querySelector('.btn-group .btn');

        // Hapus error message sebelumnya kalau ada
        row.querySelectorAll('.error-message').forEach(el => el.remove());
        dropdownButton.classList.remove('error-border');
        catatanEl.classList.remove('error-border');

        let hasError = false;

        // Validasi Action Plan
        if (actionPlan === "") {
            dropdownButton.classList.add('error-border');

            const errorMessage = document.createElement('div');
            errorMessage.classList.add('error-message');
            errorMessage.textContent = "Pilih Action Plan dulu.";
            dropdownButton.closest('td').appendChild(errorMessage);


            hasError = true;
        }

        // Validasi Catatan
        if (catatan === "") {
            catatanEl.classList.add('error-border');

            const errorMessage = document.createElement('div');
            errorMessage.classList.add('error-message');
            errorMessage.textContent = "Catatan wajib diisi.";
            catatanEl.parentNode.appendChild(errorMessage);

            hasError = true;
        }

        // Kalau ada error, jangan lanjut
        if (hasError) {
            return;
        }

        // Kalau lolos validasi, ubah tombol jadi centang tanpa ubah warna
        button.innerHTML = "✔";
        button.disabled = true;
        button.style.backgroundColor = "transparent";
        button.style.color = "black";
        button.style.border = "none";
        button.style.fontSize = "20px";
        // Contoh log data
        console.log("Defect:", namaDefect);
        console.log("Jumlah:", jumlahDefect);
        console.log("Action Plan:", actionPlan);
        console.log("Catatan:", catatan);
    }
</script>