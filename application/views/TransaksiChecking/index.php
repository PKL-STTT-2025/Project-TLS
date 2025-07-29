<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fa;
    color: #000000; 
  }
  .card-custom {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
  }
  .btn-round {
    border-radius: 2rem;
    padding: 0.3rem 1rem;
    font-size: 0.875rem;
    margin-left: 0.5rem;
  }
  .dashboard-title {
    font-weight: 600;
    font-size: 1.75rem;
    margin-bottom: 1rem;
    color: #000000;
  }
  label {
    color: #000000;
  }
  .round-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
  }
  .round-buttons .btn {
    background-color: #e0f0ff;
    color: #005b96;
    border: 1px solid #c2e0f4;
  }
  .round-buttons .btn:hover {
    background-color: #d0e9ff;
  }
</style>

<?php
function hitungSesiDariJam($time) {
    $time = date('H:i', strtotime($time));
    if ($time >= '07:15' && $time <= '09:59') {
        return 'Sesi 1';
    } elseif ($time >= '10:00' && $time <= '11:29') {
        return 'Sesi 2';
    } elseif ($time >= '13:00' && $time <= '14:59') {
        return 'Sesi 3';
    } elseif ($time >= '15:00' && $time <= '16:15') {
        return 'Sesi 4';
    } else {
        return '-';
    }
}
?>

<div class="container-fluid px-4 py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="dashboard-title mb-0">GI - TLS Input Defect</h2>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success mt-2 mb-3">
      <?= $this->session->flashdata('success') ?>
    </div>
  <?php endif; ?>

  <div class="card card-custom mb-4">
    <div class="card-header bg-white border-bottom">
      <h5 class="mb-0">Form Input Line, Style, Color & ORC</h5>
    </div>
    <div class="card-body">
      <form id="selectionForm" method="get" action="<?= site_url('TransaksiChecking') ?>">
        <div class="row g-3">
          <div class="col-md-3">
            <label>Line</label>
            <select class="form-control" name="Workgroup" id="Workgroup" required>
              <option value="">-- Pilih Line --</option>
              <?php foreach ($line_list as $line): ?>
                <option value="<?= $line['idWG']; ?>" <?= ($this->input->get('Workgroup') == $line['idWG']) ? 'selected' : '' ?>><?= $line['Workgroup']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label>Style</label>
            <select class="form-control" name="style" id="style" required <?= empty($this->input->get('Workgroup')) ? 'disabled' : '' ?>>
              <option value="">-- Pilih Style --</option>
              <?php if(!empty($style_list)): ?>
                <?php foreach ($style_list as $style): ?>
                  <option value="<?= $style['id_operation_breakdown']; ?>" <?= ($this->input->get('style') == $style['id_operation_breakdown']) ? 'selected' : '' ?>><?= $style['style']; ?> (<?= date('d/m/Y', strtotime($style['date_created'])); ?>)</option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
          <div class="col-md-3">
            <label>Color</label>
            <input type="text" class="form-control" id="color" name="color" value="<?= htmlspecialchars($this->input->get('color') ?? '') ?>">
          </div>
          <div class="col-md-3">
            <label>ORC</label>
            <input type="text" class="form-control" id="orc" name="orc" value="<?= htmlspecialchars($this->input->get('orc') ?? '') ?>">
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Daftar QC Inline</h4>
    <?php if($this->input->get('Workgroup') && $this->input->get('style') && $this->input->get('color') && $this->input->get('orc')): ?>
      <button class="btn btn-success" id="btnAdd"><i class="fas fa-plus"></i> Tambah Data</button>
    <?php else: ?>
      <button class="btn btn-secondary" disabled><i class="fas fa-plus"></i> Tambah Data</button>
    <?php endif; ?>
  </div>

  <!-- <div class="d-flex justify-content-start align-items-center mb-3 gap-2">   -->
  <nav class="navbar navbar-light bg-light">
        <form class="form-inline" method="get" action="<?= base_url('TransaksiChecking') ?>">
            <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </nav>

  <!-- <div class="d-flex gap-2 ms-3">
    <h6 class="mb-0"> Session </h6>
    <button class="btn btn-outline-primary rounded-0">1</button>
    <button class="btn btn-outline-primary rounded-0">2</button>
    <button class="btn btn-outline-primary rounded-0">3</button>
    <button class="btn btn-outline-primary rounded-0">4</button>
  </div>
</div> -->



  <div class="card card-custom">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Line</th>
              <th>Style</th>
              <th>Color</th>
              <th>ORC</th>
              <th>Tanggal</th>
              <th>Session</th>
              <th>Aksi</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($TransaksiChecking)) : ?>
              <?php $i = 1; foreach ($TransaksiChecking as $transaksi): ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $transaksi['line_name'] ?? '-' ?></td>
                  <td><?= $transaksi['style'] ?? '-' ?></td>
                  <td><?= $transaksi['color'] ?? '-' ?></td>
                  <td><?= $transaksi['orc'] ?? '-' ?></td>
                  <td><?= date('d-m-Y H:i', strtotime($transaksi['date_created'])) ?></td>
                  <td><?= hitungSesiDariJam($transaksi['date_created']) ?></td>
                  <td>
                    <a href="<?= base_url('TransaksiChecking/detail/'.$transaksi['id_transaksi_checking']) ?>" class="btn btn-sm btn-info">Detail</a>
                    <a href="<?= base_url('TransaksiChecking/ubah/'.$transaksi['id_transaksi_checking']) ?>" class="btn btn-sm btn-warning">Ubah</a>
                    <a href="<?= base_url('TransaksiChecking/hapus/'.$transaksi['id_transaksi_checking']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?');">Hapus</a>
                  </td>
                  <td>
                    <?php if ($transaksi['masalah_selesai'] === '1'): ?>
                      <span class="badge bg-success">Done</span>
                    <?php else: ?>
                      <span class="badge bg-danger">Not Done</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="7" class="text-center">Belum ada data. Silakan pilih Line, Style, Color, dan ORC terlebih dahulu.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

    $('#Workgroup').change(function() {
        var lineId = $(this).val();
        var styleSelect = $('#style');
        
        if(lineId) {
            styleSelect.prop('disabled', false);
            $.ajax({
                url: "<?= base_url('TransaksiChecking/getStyleByLine') ?>",
                method: "POST",
                data: { Workgroup: lineId },
                dataType: "json",
                success: function(response) {
                    styleSelect.empty().append('<option value="">-- Pilih Style --</option>');
                    $.each(response, function(i, style) {
                        var dateCreated = new Date(style.date_created);
                        var formattedDate = dateCreated.getDate().toString().padStart(2, '0') + '/' + 
                                            (dateCreated.getMonth()+1).toString().padStart(2, '0') + '/' + 
                                            dateCreated.getFullYear();
                        
                        styleSelect.append(
                            '<option value="' + style.id + '">' + 
                            style.style + ' (' + formattedDate + ')' +
                            '</option>'
                        );
                    });
                    $('#selectionForm').submit();
                }
            });
        } else {
            styleSelect.empty().append('<option value="">-- Pilih Style --</option>').prop('disabled', true);
        }
    });

    $('#style').change(function() {
        if($(this).val()) {
            $('#selectionForm').submit();
        }
    });
    $('#color').change(function() {
        $('#selectionForm').submit();
    });
    $('#orc').change(function() {
        $('#selectionForm').submit();
    });

    $('#btnAdd').click(function(e) {
        e.preventDefault();
        const line = $('#Workgroup').val();
        const style = $('#style').val();
        const color = $('#color').val();
        const orc = $('#orc').val();

        if (!line || !style) {
            alert('Harap pilih Line dan Style terlebih dahulu!');
            return;
        }

        const url = `<?= base_url('TransaksiChecking/tambah') ?>?Workgroup=${line}&style=${style}&color=${encodeURIComponent(color)}&orc=${encodeURIComponent(orc)}`;
        window.location.href = url;
    });
});
</script>
