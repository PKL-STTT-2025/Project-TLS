<div class="container p-3 p-md-5">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>List Checking Time</h2>
            </div>

            <form action="<?= base_url('Supervisor/action_plan') ?>" method="get" class="d-flex mt-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Search..." aria-label="Search">
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

                            <body>
                                <?php if (!empty($ActionPlan)) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($ActionPlan as $AP) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $AP->deskripsi_defect ?? '-' ?></td>
                                            <td><?= $AP->jumlah ?? '-' ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                            </td>
                                            <td>
                                                <textarea name="catatan[]" class="form-control" rows="2" placeholder="Tulis catatan..."></textarea>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-primary">Go</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Belum ada data. Silakan pilih Line dan Style terlebih dahulu.</td>
                                    </tr>
                                <?php endif; ?>
                            </body>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="<?= base_url('Supervisor'); ?>" class="btn btn-secondary ml-4 mt-3">Kembali</a>