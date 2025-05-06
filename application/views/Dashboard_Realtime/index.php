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