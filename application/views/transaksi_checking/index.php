<div class="container p-5">
    <title>Transaksi Checking</title>
    <form method="post" action="<?= base_url('TransaksiChecking/index'); ?>">
        <div class="row">
            <div class="col-md-4">
                <label>Line:</label>
                <select class="form-control" name="Workgroup" id="Workgroup" required>
                    <option value="">-- Pilih Line --</option>
                    <?php foreach ($line_list as $line): ?>
                        <option value="<?= $line['idWG']; ?>"><?= $line['Workgroup']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label>Style:</label>
                <select class="form-control" name="style" id="style" required>
                    <option value="">-- Pilih Style --</option>
                </select>
            </div>
            
                 <!-- jQuery AJAX -->
                <script>
                    $(document).ready(function() {

                        $('#Workgroup').change(function() {
                            var line = $(this).val();
                            // console.log(line);

                            if (line != '') {
                                $.ajax({
                                    url: "<?= base_url('TransaksiChecking/getStyleByLine'); ?>",
                                    method: "POST",
                                    data: {
                                        Workgroup: line
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        // console.log(response)
                                        $("#style").empty();
                                        $("#style").append('<option value="">-- Pilih Style --</option>');

                                        $.each(response, function(index, item) {
                                            // console.log(index, item)
                                            $("#style").append('<option value="' + item.id_operation_breakdown + '">' + item.style + " | "  + item.date_created  + '</option>');
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.log("Error: " + xhr.responseText);
                                    }
                                });
                            } else {
                                $('#style').empty();
                            }
                        });
                    });
                </script>

            <div class="col-md-4 mt-4">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <?php if ($this->session->flashdata('flash')) : ?>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="alert alert-success alert-dismissible fade show" role ="alert">
                    Data Input Defect <strong ><?= $this->session ->flashdata('flash'); ?></strong>
                    <button type= "button" classs="btn-close" data-bs-dismiss="alert" aria-table ='close' aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <div class="col-md-6">
            <h2>Transaksi Checking</h2>
            <a href="<?= base_url(); ?>transaksi_checking/tambah" class="btn btn-primary">Tambah Data Input Defect</a>
            <form action="" method="post" class="d-flex mt-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Search..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="row mt 3">
        <div class="col md 6">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>Kode Proses</th>
                    <th>Nama Proses</th>
                    <th>Nama Operator</th>
                    <!-- <th>Kode Defect</th>
                    <th>Deskripsi Defect</th>
                    <th>Kategori</th> -->
                    <th>Aksi</th>
                    <th>Masalah Selesai</th>
                    </tr>
                </thead>
                <?php if (!empty($transaksi_checking)) : ?>
                        <?php foreach ($transaksi_checking as $transaksi) : ?>
                        <?php endforeach; ?>
                <?php else : ?>
                        <tr>
                            <td colspan="10" class="text-center">Belum ada data.</td>
                        </tr>
                    <?php endif; ?>
                    <tbody>
                    <?php if (!empty($transaksi_checking)) : ?>
                        <?php $i = 1; ?>
                        <?php foreach ($transaksi_checking as $transaksi) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $transaksi['operation_code'] ?? '-' ?></td>
                                <td><?= $transaksi['operation_name'] ?? '-' ?></td>
                                <td><?= $transaksi['employee_name'] ?? '-' ?></td>
                                <td>
                                    <a href="<?= base_url('transaksi_checking/detail/'.$transaksi['id']) ?>" class="btn btn-info">Detail</a>
                                    <a href="<?= base_url('transaksi_checking/ubah/'.$transaksi['id']) ?>" class="btn btn-warning">Ubah</a>
                                    <a href="<?= base_url('transaksi_checking/hapus/'.$transaksi['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
                                </td>
                                <td>
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
    </div>
</div>

