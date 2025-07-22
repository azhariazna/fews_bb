<?php echo $this->extend('admin/layout') ?>
<?php echo $this->section('content') ?>

<div class="container mt-4">
    <h4 class="mb-4">Status Simulasi AWLR</h4>
    <div class="row">
        <!-- Sampir Card -->
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    AWLR Sampir
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> <span class="badge bg-<?= ($status_sampir == 'Awas') ? 'danger' : (($status_sampir == 'Siaga') ? 'warning' : 'success') ?>"><?= $status_sampir ?></span></p>
                    <p><strong>TMA Maksimum:</strong> <?= number_format($max_sampir, 2) ?> m</p>
                    <p><strong>Waktu:</strong> <?= esc($max_sampir_time) ?></p>
                </div>
            </div>
        </div>

        <!-- Menemeng Card -->
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    AWLR Menemeng
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> <span class="badge bg-<?= ($status_menemeng == 'Awas') ? 'danger' : (($status_menemeng == 'Siaga') ? 'warning' : 'success') ?>"><?= $status_menemeng ?></span></p>
                    <p><strong>TMA Maksimum:</strong> <?= number_format($max_menemeng, 2) ?> m</p>
                    <p><strong>Waktu:</strong> <?= esc($max_menemeng_time) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <!-- Grafik Sampir -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Grafik TMA - Sampir
                </div>
                <div class="card-body">
                    <canvas id="chartSampir"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Menemeng -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Grafik TMA - Menemeng
                </div>
                <div class="card-body">
                    <canvas id="chartMenemeng"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <!-- Tabel Sampir -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Tabel Simulasi - Sampir
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Waktu</th>
                                <th>TMA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_sampir as $row): ?>
                                <tr>
                                    <td><?= esc($row['id']) ?></td>
                                    <td><?= esc($row['waktu']) ?></td>
                                    <td><?= number_format($row['tma'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabel Menemeng -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Tabel Simulasi - Menemeng
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Waktu</th>
                                <th>TMA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_menemeng as $row): ?>
                                <tr>
                                    <td><?= esc($row['id']) ?></td>
                                    <td><?= esc($row['waktu']) ?></td>
                                    <td><?= number_format($row['tma'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const sampirData = <?= json_encode($data_sampir) ?>;
    const menemengData = <?= json_encode($data_menemeng) ?>;

    new Chart(document.getElementById('chartSampir'), {
        type: 'line',
        data: {
            labels: sampirData.map(r => r.waktu),
            datasets: [{
                label: 'TMA (m)',
                data: sampirData.map(r => r.tma),
                borderColor: 'blue',
                borderWidth: 2,
                fill: false,
                pointRadius: 0
            }]
        }
    });

    new Chart(document.getElementById('chartMenemeng'), {
        type: 'line',
        data: {
            labels: menemengData.map(r => r.waktu),
            datasets: [{
                label: 'TMA (m)',
                data: menemengData.map(r => r.tma),
                borderColor: 'green',
                borderWidth: 2,
                fill: false,
                pointRadius: 0
            }]
        }
    });
</script>

<?php echo $this->endSection() ?>
