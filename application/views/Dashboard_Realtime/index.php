<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .chart-small {
            width: 180px !important;
            height: 180px !important;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php $this->load->view('templates/sidebar'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php $this->load->view('templates/topbar'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div id="dashboard-defect" style="display: block;">
                        <h1 class="h3 mb-4 text-gray-800">Dashboard Defect</h1>
                        <div class="container text-center mt-4">

                            <div class="container mt-4">

                                <div class="row mb-4 justify-content-center">
                                    <div class="col-md-3">
                                        <div class="card text-center shadow-sm">
                                            <div class="card-body">
                                                <i class="fas fa-user fa-2x mb-2 text-secondary"></i>
                                                <h5 class="card-title">Farah</h5>
                                                <p class="card-text">Single Needle<br><small>(Kode Proses)</small></p>
                                                <span class="badge bg-success">Active</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card text-center shadow-sm">
                                            <div class="card-body">
                                                <i class="fas fa-user fa-2x mb-2 text-secondary"></i>
                                                <h5 class="card-title">Lina</h5>
                                                <p class="card-text">Single Needle<br><small>(Kode Proses)</small></p>
                                                <span class="badge bg-success">Active</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center justify-content-center">
                                    <div class="col-md-3 mx-2 mb-4">
                                        <h6>Persentase Today Defect</h6>
                                        <div class="chart-container">
                                            <canvas id="chartToday"></canvas>
                                        </div>
                                        <div class="mt-2 small">
                                            <span style="color:#ff4d4d">● 3 Operator</span><br>
                                            <span style="color:#ffcc00">● 4 Operator</span><br>
                                            <span style="color:#66cc66">● 18 Operator</span>
                                        </div>
                                    </div>

                                    <!-- WEEK -->
                                    <div class="col-md-3 mx-2 mb-4">
                                        <h6>Persentase Week Defect</h6>
                                        <div class="chart-container">
                                            <canvas id="chartWeek"></canvas>
                                        </div>
                                        <div class="mt-2 small">
                                            <span style="color:#ff4d4d">● 3 Operator</span><br>
                                            <span style="color:#ffcc00">● 4 Operator</span><br>
                                            <span style="color:#66cc66">● 18 Operator</span>
                                        </div>
                                    </div>

                                    <!-- MONTH -->
                                    <div class="col-md-3 mx-2 mb-4">
                                        <h6>Persentase Month Defect</h6>
                                        <div class="chart-container">
                                            <canvas id="chartMonth"></canvas>
                                        </div>
                                        <div class="mt-2 small">
                                            <span style="color:#ff4d4d">● 3 Operator</span><br>
                                            <span style="color:#ffcc00">● 4 Operator</span><br>
                                            <span style="color:#66cc66">● 18 Operator</span>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>


                    </div>

                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const createChart = (id, data) => {
            new Chart(document.getElementById(id), {
                type: 'doughnut',
                data: {
                    labels: ['3 Operator', '4 Operator', '18 Operator'],
                    datasets: [{
                        data: data,
                        backgroundColor: ['#ff4d4d', '#ffcc00', '#66cc66'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    cutout: '70%'
                }
            });
        };

        createChart('chartToday', [10, 20, 70]);
        createChart('chartWeek', [15, 25, 60]);
        createChart('chartMonth', [5, 35, 60]);
    </script>


</body>

</html>