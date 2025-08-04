<?php echo $this->extend('admin/layout') ?>
<?php echo $this->section('content') ?>

<div class="container mt-4">
    <h4 class="mb-4">Download Data Sensor (API AVW per Tanggal)</h4>

    <form method="post" class="row g-3 mb-4" autocomplete="off">
        <?= csrf_field() ?>
        <div class="col-md-4">
            <label for="sensor" class="form-label">Pilih Sensor</label>
            <select class="form-select" name="sensor" id="sensor" required>
                <option value="">-- Pilih Sensor --</option>
                <?php foreach ($sensorList as $s): ?>
                    <option value="<?= esc($s) ?>" <?= ($s === $selectedSensor) ? 'selected' : '' ?>><?= esc($s) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= esc($selectedDate) ?>" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
        </div>
        <?php if (!empty($records)): ?>
            <div class="col-md-3 d-flex align-items-end justify-content-end">
                <button id="btnExport" type="button" class="btn btn-success w-100">Export ke Excel</button>
            </div>
        <?php endif; ?>
    </form>

    <?php if ($error): ?>
        <div class="alert alert-warning"><?= esc($error) ?></div>
    <?php elseif (!empty($records)): ?>
        <div class="table-responsive">
            <table id="sensorTable" class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th class="text-center align-middle">Waktu</th>
                        <?php foreach ($parameters as $p): ?>
                            <th class="text-center align-middle"><?= esc($p) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $row): ?>
                        <tr>
                            <td class="text-center align-middle"><?= esc($row['waktu']) ?></td>
                            <?php foreach ($parameters as $p): ?>
                                <td class="text-center align-middle"><?= isset($row[$p]) ? esc($row[$p]) : '-' ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($isPost): ?>
        <div class="alert alert-info">Data tidak ditemukan untuk sensor dan tanggal yang dipilih.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
    document.getElementById('btnExport')?.addEventListener('click', function () {
        const table = document.getElementById('sensorTable');
        const wb = XLSX.utils.table_to_book(table, { sheet: "Data Sensor" });
        XLSX.writeFile(wb, "data_sensor.xlsx");
    });
</script>

<?php if (isset($apiRaw)): ?>
<script>
    // Tampilkan isi response API ke console browser
    console.log("API RAW RESPONSE:", <?= json_encode($apiRaw) ?>);
    try {
        console.log("API JSON PARSED:", JSON.parse(<?= json_encode($apiRaw) ?>));
    } catch(e) {
        console.log("API response is not valid JSON");
    }
</script>
<?php endif; ?>

<?php echo $this->endSection() ?>
