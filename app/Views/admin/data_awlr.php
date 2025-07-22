<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <h4>Data AWLR per Tanggal</h4>

    <form method="get" action="">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_awlr" class="form-label">Pilih AWLR</label>
                <select name="id_awlr" id="id_awlr" class="form-select">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($awlrList as $pos): ?>
                        <option value="<?= $pos['id'] ?>" <?= $id_awlr == $pos['id'] ? 'selected' : '' ?>>
                            <?= esc($pos['nama_lokasi']) ?>
                        </option>
                    <?php endforeach; ?>
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
    </form>

    <?php if (!empty($data)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-sm table-hover">
                <button id="exportBtn" class="btn btn-success mt-3">Export ke Excel</button>

                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <th>TMA (cm)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= esc($row['waktu']) ?></td>
                            <td><?= esc($row['tma']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($id_awlr && $start && $end): ?>
        <div class="alert alert-warning">Tidak ada data untuk periode ini.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.getElementById("exportBtn").addEventListener("click", function () {
        var wb = XLSX.utils.book_new();
        var table = document.querySelector("table");
        var ws = XLSX.utils.table_to_sheet(table);
        XLSX.utils.book_append_sheet(wb, ws, "Data");

        let namaPos = document.getElementById("id_awlr").selectedOptions[0].text.replace(/\s+/g, "_");
        let start = document.getElementById("start").value;
        let end = document.getElementById("end").value;
        let filename = `${namaPos}_${start}_sd_${end}.xlsx`;

        XLSX.writeFile(wb, filename);
    });
</script>
