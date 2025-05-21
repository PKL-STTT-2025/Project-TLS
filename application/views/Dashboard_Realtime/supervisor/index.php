<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div id="dashboard-defect" style="display: block;">
        <h1 class="h3 mb-4 text-gray-800 mt-3">Dashboard Defect</h1>
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
                <!-- TODAY -->
                <div class="row justify-content-center mb-4">
                    <!-- Doughnut Chart -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Persentase Today Defect</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2" style="height: 250px;">
                                    <canvas id="ChartTodayPie"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2"><i class="fas fa-circle text-primary"></i> 3 Operator</span>
                                    <span class="mr-2"><i class="fas fa-circle text-success"></i> 4 Operator</span>
                                    <span class="mr-2"><i class="fas fa-circle text-info"></i> 18 Operator</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- WEEK -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Persentase Week Defect</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2" style="height: 250px;">
                                    <canvas id="ChartWeekPie"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2"><i class="fas fa-circle text-primary"></i> 3 Operator</span>
                                    <span class="mr-2"><i class="fas fa-circle text-success"></i> 4 Operator</span>
                                    <span class="mr-2"><i class="fas fa-circle text-info"></i> 18 Operator</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MONTH -->

                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Persentase Month Defect</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2" style="height: 250px;">
                                    <canvas id="ChartMonthPie"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2"><i class="fas fa-circle text-primary"></i> 3 Operator</span>
                                    <span class="mr-2"><i class="fas fa-circle text-success"></i> 4 Operator</span>
                                    <span class="mr-2"><i class="fas fa-circle text-info"></i> 18 Operator</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                <a class="btn btn-primary" href="<?= base_url('auth'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- CHART.JS SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const createDoughnutChart = (id, data, title) => {
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
                        display: false,

                    },
                    title: {
                        display: true,
                        text: title,
                        font: {
                            size: 14
                        }
                    }
                },
                cutout: '70%'
            }
        });
    };

    // Contoh data (kamu tinggal ganti sesuai kebutuhan)
    createDoughnutChart('ChartTodayPie', [10, 20, 70], 'Today Defect');
    createDoughnutChart('ChartWeekPie', [15, 25, 60], 'Week Defect');
    createDoughnutChart('ChartMonthPie', [5, 35, 60], 'Month Defect');
</script>