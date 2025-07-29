<style>
    .error-border {
        border: 2px solid red;
    }

    .error-message {
        color: red;
        font-size: 0.85rem;
        margin-top: 4px;
    }

    /* Judul */
    h2 {
        color: #000 !important;
    }

    /* Input search */
    form input[type="text"]::placeholder,
    form input[type="text"] {
        color: #000 !important;
    }

    /* Teks di tabel */
    table td,
    table th {
        color: #000 !important;
    }

    .table thead th {
        text-align: center;
        vertical-align: middle !important;
    }

    .table td:nth-child(3),
    .table th:nth-child(3) {
        text-align: center;
    }
</style>

<div class="container p-3 p-md-5">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>GI-TLS List Action Plan</h2>

            <!-- Search -->
            <form action="<?= base_url('Supervisor/action_plan/' . $id_transaksi_checking) ?>" method="get" class="d-flex mt-3">
                <input type="text" name="keyword" value="<?= $this->input->get('keyword'); ?>" class="form-control me-2" placeholder="Search..." aria-label="Search">
                <button class="btn btn-outline-success ml-4" type="submit">Search</button>
            </form>

            <!-- Table -->
            <div class="table-responsive mt-4">
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
                            <?php $i = 1;
                            foreach ($ActionPlan as $AP) : ?>
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
                                <td colspan="6" class="text-center">Belum ada data.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Selesai & Kembali -->
            <div class="row mt-4">
                <div class="col">
                    <a href="<?= base_url('Supervisor/selesai/' . $id_transaksi_checking) ?>" class="btn btn-success">Selesai</a>
                    <a href="<?= base_url('Supervisor') ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- JS -->
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

        // Hapus error message sebelumnya
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

        if (hasError) return;

        // Kalau lolos validasi
        button.innerHTML = "✔";
        button.disabled = true;
        button.style.backgroundColor = "transparent";
        button.style.color = "black";
        button.style.border = "none";
        button.style.fontSize = "20px";

        console.log("Defect:", namaDefect);
        console.log("Jumlah:", jumlahDefect);
        console.log("Action Plan:", actionPlan);
        console.log("Catatan:", catatan);
    }
</script>