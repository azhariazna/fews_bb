<!DOCTYPE html>
<html>
<head>
    <title>Data AVW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4" style="background-color: skyblue;">
    <h3 class="mb-4">Data AVW Logger 10245</h3>
    <?php if (!empty($errorMsg)): ?>
        <div class="alert alert-danger"><?= esc($errorMsg) ?></div>
    <?php endif; ?>


    <!-- Form Pilihan Sensor dan Tanggal -->
    <form method="post" action="<?= base_url('api-download/fetch') ?>" class="row g-3 mb-2">
        <div class="col-md-4">
            <label for="sensor" class="form-label">Pilih Sensor</label>
            <select name="sensor" id="sensor" class="form-select">
                <?php foreach ($sensors as $sensor): ?>
                    <option value="<?= $sensor ?>" <?= $sensor == $selectedSensor ? 'selected' : '' ?>>
                        <?= $sensor ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="tanggal" class="form-label">Pilih Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="<?= esc($selectedDate) ?>" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Tampilkan Data</button>
        </div>
    </form>

    <!-- Tombol Export Excel -->
    <?php if (!empty($dataList)): ?>
        <button onclick="exportTableToExcel('avwTable', 'Data_AVW_<?= $selectedSensor ?>_<?= $selectedDate ?>')" class="btn btn-success mb-3">
            Export ke Excel
        </button>
    <?php endif; ?>

    <!-- Tabel Data -->
    <?php if (empty($dataList)): ?>
        <div class="alert alert-warning">Data tidak tersedia atau gagal dimuat.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table id="avwTable" class="table table-bordered table-striped table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <?php foreach ($dataList[0]['data'] as $param): ?>
                            <th><?= esc($param['nama_parameter']) ?> (<?= esc($param['satuan']) ?>)</th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataList as $entry): ?>
                        <tr>
                            <td><?= esc($entry['waktu']) ?></td>
                            <?php foreach ($entry['data'] as $param): ?>
                                <td><?= esc($param['nilai']) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- Script Export Excel -->
    <script>
    function exportTableToExcel(tableID, filename = '') {
        const downloadLink = document.createElement("a");
        const dataType = 'application/vnd.ms-excel';
        const tableSelect = document.getElementById(tableID);
        const tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        filename = filename ? filename + '.xls' : 'data_avw.xls';

        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
    </script>
</body>
</html>
