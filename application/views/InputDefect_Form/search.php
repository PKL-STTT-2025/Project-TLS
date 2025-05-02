<!DOCTYPE html>
<html>
<head>
    <title>Search Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h3>Search Workgroup</h3>
    
    <form action="<?= base_url('InputDefect_Form/search') ?>" method="post">
        <div class="mb-3">
            <label for="Workgroup" class="form-label">Workgroup</label>
            <select name="Workgroup" id="Workgroup" class="form-select" required>
                <option value="">-- Pilih Workgroup --</option>
                <?php foreach ($lines as $Workgroup): ?>
                    <option value="<?= $Workgroup['Workgroup'] ?>"><?= $Workgroup['Workgroup'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="Style" class="form-label">Style</label>
            <input type="text" class="form-control" id="Style" name="Style" placeholder="Opsional">
        </div>

        <div class="mb-3">
            <label for="ORC" class="form-label">ORC</label>
            <input type="text" class="form-control" id="ORC" name="ORC" placeholder="Opsional">
        </div>

        <button type="submit" class="btn btn-primary">Cari Layout</button>
    </form>

</body>
</html>
