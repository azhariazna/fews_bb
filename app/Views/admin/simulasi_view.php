<?php echo $this->extend('admin/layout') ?>
<?php echo $this->section('content') ?>

<div class="container mt-4">
    <h4 class="mb-4">Status Simulasi Bendungan</h4>
    <div class="row">
        <!-- Tiu Suntuk Card -->
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    Bendungan Tiu Suntuk
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> <span class="badge bg-<?= ($status_tiu == 'Awas') ? 'danger' : (($status_tiu == 'Siaga') ? 'warning' : 'success') ?>"><?= $status_tiu ?></span></p>
                    <p><strong>Elevasi Maksimum:</strong> <?= number_format($max_tiu, 2) ?> m</p>
                    <p><strong>Waktu:</strong> <?= esc($max_tiu_time) ?></p>
                </div>
            </div>
        </div>


        <!-- Bintang Bano Card -->
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    Bendungan Bintang Bano
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> <span class="badge bg-<?= ($status_bano == 'Awas') ? 'danger' : (($status_bano == 'Siaga') ? 'warning' : 'success') ?>"><?= $status_bano ?></span></p>
                    <p><strong>Elevasi Maksimum:</strong> <?= number_format($max_bano, 2) ?> m</p>
                    <p><strong>Waktu:</strong> <?= esc($max_bano_time) ?></p>
                </div>
            </div>
        </div>
    </div>

        <div class="row mt-5">
        <!-- Grafik Elevasi -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Grafik Elevasi - Tiu Suntuk
                </div>
                <div class="card-body">
                    <canvas id="chartTiu"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Grafik Elevasi - Bintang Bano
                </div>
                <div class="card-body">
                    <canvas id="chartBano"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <!-- Tabel Tiu Suntuk -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Data Simulasi - Tiu Suntuk
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Waktu</th>
                                    <th>Inflow</th>
                                    <th>Outflow</th>
                                    <th>Elevasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tiu_suntuk as $row): ?>
                                    <tr>
                                        <td><?= esc($row['id']) ?></td>
                                        <td><?= esc($row['waktu']) ?></td>
                                        <td><?= number_format($row['inflow'], 2) ?></td>
                                        <td><?= number_format($row['outflow'], 2) ?></td>
                                        <td><?= number_format($row['elevasi'], 2) ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Bintang Bano -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Data Simulasi - Bintang Bano
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Waktu</th>
                                    <th>Inflow</th>
                                    <th>Outflow</th>
                                    <th>Elevasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bintang_bano as $row): ?>
                                    <tr>
                                        <td><?= esc($row['id']) ?></td>
                                        <td><?= esc($row['waktu']) ?></td>
                                        <td><?= number_format($row['inflow'], 2) ?></td>
                                        <td><?= number_format($row['outflow'], 2) ?></td>
                                        <td><?= number_format($row['elevasi'], 2) ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tiuData = <?= json_encode($tiu_suntuk) ?>;
        const banoData = <?= json_encode($bintang_bano) ?>;

        // === Grafik Tiu Suntuk ===
        new Chart(document.getElementById('chartTiu').getContext('2d'), {
            type: 'line',
            data: {
                labels: tiuData.map(item => item.waktu),
                datasets: [
                    {
                        label: 'Elevasi (m)',
                        data: tiuData.map(item => item.elevasi),
                        borderColor: 'blue',
                        yAxisID: 'y',
                        tension: 0.3,
                        fill: false
                    },
                    {
                        label: 'Inflow (m³/dtk)',
                        data: tiuData.map(item => item.inflow),
                        borderColor: 'orange',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: false
                    },
                    {
                        label: 'Outflow (m³/dtk)',
                        data: tiuData.map(item => item.outflow),
                        borderColor: 'red',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                stacked: false,
                scales: {
                    y: {
                        type: 'linear',
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Elevasi (m)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Debit (m³/dtk)'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });

        // === Grafik Bintang Bano ===
        new Chart(document.getElementById('chartBano').getContext('2d'), {
            type: 'line',
            data: {
                labels: banoData.map(item => item.waktu),
                datasets: [
                    {
                        label: 'Elevasi (m)',
                        data: banoData.map(item => item.elevasi),
                        borderColor: 'green',
                        yAxisID: 'y',
                        tension: 0.3,
                        fill: false
                    },
                    {
                        label: 'Inflow (m³/dtk)',
                        data: banoData.map(item => item.inflow),
                        borderColor: 'orange',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: false
                    },
                    {
                        label: 'Outflow (m³/dtk)',
                        data: banoData.map(item => item.outflow),
                        borderColor: 'red',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                stacked: false,
                scales: {
                    y: {
                        type: 'linear',
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Elevasi (m)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Debit (m³/dtk)'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    });
</script>


<?php echo $this->endSection() ?>