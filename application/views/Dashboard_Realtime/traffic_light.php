<!-- View: traffic_light.php -->
<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(5, minmax(180px, 1fr));
        gap: 20px;
        justify-items: center;
    }

    .card-operator {
        width: 100%;
        max-width: 180px;
    }

    .card-title {
        font-size: 16px;
        margin-bottom: 4px;
    }

    .card-text {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 6px;
    }

    .badge {
        font-size: 12px;
    }
</style>

<div class="container mt-4">
    <h3 class="text-center mb-4"><?= $title ?> - LINE <?= strtoupper($line_name ?? '') ?></h3>
    <div class="grid-container">
        <?php foreach ($operators as $op): ?>
            <div class="card text-center shadow-sm card-operator">
                <div class="card-body">
                    <i class="fas fa-user fa-2x mb-2 text-secondary"></i>
                    <h5 class="card-title"><?= $op->operator_name ?></h5>
                    <p class="card-text"><small>(<?= $op->nama_mesin ?>)</small></p>
                    <p class="card-text"><small>(<?= $op->kode_proses ?>)</small></p>

                    <?php
                    // Simulasi status, ganti sesuai field dari database misal $op->status
                    $status = strtolower($op->status ?? 'active');
                    $badgeClass = [
                        'active' => 'bg-success',
                    ][$status] ?? 'bg-secondary';
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>