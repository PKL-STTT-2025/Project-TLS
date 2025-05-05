<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Harian</title>
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- Custom styles -->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-header {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            font-size: 1.25rem;
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: white;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <?php $this->load->view('templates/sidebar'); ?>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar -->
                <?php $this->load->view('templates/topbar'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Laporan Harian</h1>

                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar"></i> Laporan Harian
                        </div>
                        <div class="card-body bg-white">
                            <canvas id="chartHari" height="300"></canvas>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <?php $this->load->view('/templates/footer'); ?>
            <!-- End of Footer -->

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
    <script>
        const ctx = document.getElementById('chartHari').getContext('2d');
        const chartHari = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($hari); ?>,
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: <?= json_encode($jumlah); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafik Jumlah Laporan per Hari'
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>