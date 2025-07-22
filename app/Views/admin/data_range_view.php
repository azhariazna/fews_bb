<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <h4>Data Logger Bendungan Tiu Suntuk</h4>

    <form method="get" action="">
    <!-- Spinner Loading -->
    <div id="loadingSpinner" style="display:none;" class="text-center mb-3">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Mengambil data dari server...</p>
    </div>



        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_logger" class="form-label">Pilih Pos</label>
                <select name="id_logger" id="id_logger" class="form-select">
                    <option value="">-- Pilih --</option>
                    <option value="10187" <?= $id_logger == '10187' ? 'selected' : '' ?>>Pos AWLR</option>
                    <option value="10217" <?= $id_logger == '10217' ? 'selected' : '' ?>>Pos AWR</option>
                    <option value="10246" <?= $id_logger == '10246' ? 'selected' : '' ?>>Pos ARR</option>
                    <option value="10244" <?= $id_logger == '10244' ? 'selected' : '' ?>>Pos V Notch</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="start" class="form-label">Tanggal Awal</label>
                <input type="date" name="start" id="start" value="<?= esc($start) ?>" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="end" class="form-label">Tanggal Akhir</label>
                <input type="date" name="end" id="end" value="<?= esc($end) ?>" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
            </div>
        </div>

        <?php if (!empty($dataSensor)): ?>
            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="<?= base_url("data_api/export?id_logger={$id_logger}&start={$start}&end={$end}") ?>" class="btn btn-success">
                        Export ke Excel
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </form>

    <?php if ($error): ?>
        <div class="alert alert-warning"><?= esc($error) ?></div>
    <?php elseif (!empty($dataSensor)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-sm table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <?php foreach ($headers as $header): ?>
                            <th><?= esc($header) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataSensor as $entry): ?>
                        <tr>
                            <td><?= esc($entry['waktu']) ?></td>
                            <?php
                                $paramMap = [];
                                foreach ($entry['data'] as $p) {
                                    $paramMap[$p['nama_parameter']] = $p['nilai'];
                                }
                            ?>
                            <?php foreach ($headers as $h): ?>
                                <td><?= esc($paramMap[$h] ?? '-') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Silakan pilih pos dan tanggal terlebih dahulu.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<script>
    const form = document.querySelector('form');
    form.addEventListener('submit', function (e) {
        // Tampilkan spinner
        document.getElementById('loadingSpinner').style.display = 'block';

        // Delay kecil agar spinner sempat muncul sebelum reload
        setTimeout(() => {
            form.submit(); // lanjutkan submit
        }, 100); // 100ms cukup
        e.preventDefault(); // cegah submit langsung
    });
</script>


