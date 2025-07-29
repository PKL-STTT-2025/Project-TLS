<div class="container p-5">
    <title>Report Bulanan</title>
    <h2 class="text-center mb-4">Report Bulanan</h2>
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
    </div>
</div>

<!-- Grafik -->
<div class="container mt-5">
    <canvas id="paretoChart" style="height: 400px; width: 100%;"></canvas>
</div>

<!-- CSS LANGSUNG -->
<style>
    h2.text-center {
        font-family: 'Segoe UI', sans-serif;
        font-weight: 700;
    }

    .card.bg-light {
        background-color: #f8f9fc !important;
        border-left: 5px solid #4e73df;
        border-radius: 10px;
    }

    select.form-control {
        font-size: 14px;
        padding: 10px;
        border-radius: 8px;
    }

    label.fw-semibold {
        font-weight: 600;
    }

    canvas#paretoChart {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
</style>

<!-- Script Section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let paretoChart;
    const ctx = document.getElementById('paretoChart').getContext('2d');

    $('#Workgroup').change(function() {
        const lineId = $(this).val();
        $('#style').empty().append('<option value="">-- Pilih Style --</option>');
        if (lineId !== '') {
            $.ajax({
                url: '<?= base_url("Report_Defect/getStyleByLine") ?>',
                method: 'POST',
                data: {
                    Workgroup: lineId
                },
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(index, item) {
                        $('#style').append('<option value="' + item.id_operation_breakdown + '">' + item.style + ' | ' + item.date_created + '</option>');
                    });
                }
            });
        }
    });

    $('#style').change(function() {
        const lineId = $('#Workgroup').val();
        const opbId = $(this).val();

        if (lineId && opbId) {
            $.ajax({
                url: '<?= base_url("Report_Defect/getDefectChart") ?>',
                method: 'GET',
                data: {
                    line: lineId,
                    style: opbId
                },
                dataType: 'json',
                success: function(response) {
                    const labels = response.map(d => d.deskripsi_defect);
                    const data = response.map(d => parseInt(d.total));
                    const total = data.reduce((a, b) => a + b, 0);
                    let cumulative = 0;
                    const cumPercent = data.map(val => {
                        cumulative += val;
                        return ((cumulative / total) * 100).toFixed(2);
                    });

                    const chartData = {
                        labels: labels,
                        datasets: [{
                                label: 'Jumlah Defect',
                                data: data,
                                backgroundColor: 'rgba(54, 115, 220, 0.7)',
                                borderColor: 'rgba(54, 115, 220, 1)',
                                borderWidth: 1,
                                borderRadius: 6,
                                yAxisID: 'y',
                            },
                            {
                                label: 'Kumulatif (%)',
                                data: cumPercent,
                                type: 'line',
                                borderColor: '#d4af37',
                                pointBackgroundColor: '#d4af37',
                                pointRadius: 4,
                                backgroundColor: 'rgba(212, 175, 55, 0.1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.3,
                                yAxisID: 'y1'
                            }
                        ]
                    };

                    if (paretoChart) paretoChart.destroy();

                    paretoChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Pareto Chart - Daily Defect Report',
                                    font: {
                                        size: 20,
                                        weight: 'bold',
                                        family: 'Arial'
                                    },
                                    padding: {
                                        top: 10,
                                        bottom: 15
                                    }
                                },
                                subtitle: {
                                    display: true,
                                    text: 'Line: ' + $("#Workgroup option:selected").text() + ' | Style: ' + $("#style option:selected").text(),
                                    font: {
                                        size: 14,
                                        style: 'italic'
                                    },
                                    padding: {
                                        bottom: 10
                                    }
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': ' + context.formattedValue + (context.dataset.label === 'Kumulatif (%)' ? '%' : '');
                                        }
                                    }
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        maxRotation: 0,
                                        minRotation: 0,
                                        font: {
                                            size: 11
                                        },
                                        callback: function(value, index, ticks) {
                                            const label = this.getLabelForValue(value);
                                            // Bikin label pindah baris tiap 20 karakter
                                            return label.match(/.{1,20}/g); // Array of substrings
                                        }
                                    },
                                    grid: {
                                        display: false
                                    }
                                },

                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        callback: function(value) {
                                            return Number.isInteger(value) ? value : null;
                                        },
                                        font: {
                                            size: 12
                                        }
                                    },
                                    grid: {
                                        color: '#e0e0e0'
                                    },
                                    title: {
                                        display: true,
                                        text: 'Jumlah Defect',
                                        font: {
                                            size: 14
                                        }
                                    }
                                },
                                y1: {
                                    beginAtZero: true,
                                    max: 100,
                                    position: 'right',
                                    ticks: {
                                        callback: value => value + '%',
                                        font: {
                                            size: 12
                                        }
                                    },
                                    grid: {
                                        drawOnChartArea: false
                                    },
                                    title: {
                                        display: true,
                                        text: 'Kumulatif (%)',
                                        font: {
                                            size: 14
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Update total defect box
                    $.ajax({
                        url: '<?= base_url("Report_Defect/getTotalDefect") ?>',
                        method: 'GET',
                        data: {
                            line: lineId,
                            style: opbId
                        },
                        dataType: 'json',
                        success: function(res) {
                            $('.text-danger.fw-bold').text(res.total_defect);
                        }
                    });
                }
            });
        }
    });
</script>