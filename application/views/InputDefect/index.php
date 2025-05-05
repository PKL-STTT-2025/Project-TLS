<!-- Begin Page Content -->
<div class="container-fluid">
    <h4>Input Defect</h4>
    <form method="post" action="<?= base_url('InputDefect/index'); ?>">
        <div class="form-group mb-3">
            <label>User:</label>
            <input type="text" class="form-control" name="user" value="<?= $nama_user ?>" readonly>
        </div>

        <div class="form-group mb-3">
            <label>Line:</label>
            <select class="form-control" name="Workgroup" id="Workgroup" required>
                <option value="">-- Pilih Line --</option>
                <?php foreach ($line_list as $line): ?>
                    <option value="<?= $line['Workgroup']; ?>"><?= $line['Workgroup']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Style:</label>
            <input type="text" class="form-control" name="style" id="style" readonly>
        </div>

        <div class="form-group mb-3">
            <label>ORC:</label>
            <input type="text" class="form-control" name="orc" id="orc" readonly>
        </div>

        <button type="submit" class="btn btn-primary w-100">Search</button>
    </form>

    <?php if (empty($list_transaksi)): ?>
        <div class="alert alert-warning mt-3">Belum ada data</div>
    <?php else: ?>
        <!-- tampilkan data di sini -->
    <?php endif; ?>
</div>



<script>
    $(document).ready(function() {
        $('#Workgroup').change(function() {
            var id_line = $(this).val();

            if (id_line != '') {
                $.ajax({
                    url: "<?= base_url('InputDefect/get_layout_by_Workgroup'); ?>",
                    method: "POST",
                    data: {
                        Workgroup: id_line
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#style').val(response.data.style || '');
                            $('#orc').val(response.data.orc || '');
                        } else {
                            $('#style').val('');
                            $('#orc').val('');
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + xhr.responseText);
                    }
                });
            } else {
                $('#style').val('');
                $('#orc').val('');
            }
        });
    });
</script>