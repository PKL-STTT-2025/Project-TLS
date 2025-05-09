<<<<<<< HEAD
=======
<!-- View: traffic_light.php -->
>>>>>>> farah
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

<<<<<<< HEAD
    .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        height: 220px;
        /* Bisa disesuaikan jika ingin lebih tinggi/rendah */
        padding: 10px;
    }

=======
>>>>>>> farah
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
<<<<<<< HEAD

    .traffic-light {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 10px;
    }

    .light {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: grey;
        border: 1px solid #aaa;
    }

    .light.red {
        background-color: red;
    }

    .light.yellow {
        background-color: yellow;
    }

    .light.green {
        background-color: green;
    }
=======
>>>>>>> farah
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
<<<<<<< HEAD
=======
                    // Simulasi status, ganti sesuai field dari database misal $op->status
>>>>>>> farah
                    $status = strtolower($op->status ?? 'active');
                    $badgeClass = [
                        'active' => 'bg-success',
                    ][$status] ?? 'bg-secondary';
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
<<<<<<< HEAD

                    <!-- Traffic light -->
                    <div class="traffic-light mt-2">
                        <?php
                        $defect = isset($op->defect_count)
                            ? $op->defect_count
                            : rand(0, 10); // nilai acak antara 0-10S
                        $color = 'green';
                        if ($defect > 5) {
                            $color = 'red';
                        } elseif ($defect > 2) {
                            $color = 'yellow';
                        }
                        echo '<span class="light ' . $color . '"></span>';
                        ?>
                    </div>
=======
>>>>>>> farah
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>