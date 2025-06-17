<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan RTD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: auto;
            padding: 40px;
        }
        h2 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a.download-btn {
            text-decoration: none;
            background: #4CAF50;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
        }
        a.download-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Daftar Laporan RTD</h2>

    <?php if (!empty($laporanList)) : ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($laporanList as $row) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_file']) ?></td>
                        <td>
                            <a class="download-btn" href="<?= base_url('assets/docx/' . urlencode($row['nama_file'])) ?>" target="_blank">Download</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Tidak ada laporan tersedia.</p>
    <?php endif; ?>

</body>
</html>
