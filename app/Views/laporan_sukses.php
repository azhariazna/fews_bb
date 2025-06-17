<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Sukses</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: auto;
            padding: 40px;
        }

        h2 {
            color: green;
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

    <h2>Laporan berhasil dibuat!</h2>

    <table>
        <thead>
            <tr>
                <th>Nama File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= pathinfo(urldecode(basename($docx_url)), PATHINFO_FILENAME) ?></td>
                <td><a class="download-btn" href="<?= $docx_url ?>" target="_blank">Download</a></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
