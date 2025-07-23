<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Laporan RTD</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="time"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            box-sizing: border-box;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .note {
            font-size: small;
            font-style: italic;
            color: gray;
            margin-top: 10px;
        }
    </style>
</head>
<body style="background-color: skyblue;">
    <h2>Form Laporan Keadaan Darurat</h2>

    <form action="<?= base_url('laporanrtd/submit') ?>" method="post">
        <?= csrf_field() ?>
        <label>Jam:</label>
        <input type="time" name="jam">

        <label>Tanggal:</label>
        <input type="date" name="tanggal">

        <label>Status:</label>
        <select name="status">
            <option value="WASPADA 1">WASPADA 1</option>
            <option value="WASPADA 2">WASPADA 2</option>
            <option value="SIAGA">SIAGA</option>
            <option value="AWAS">AWAS</option>
        </select>

        <label>Elevasi:</label>
        <input type="text" name="elevasi">

        <label>Elevasi Normal:</label>
        <input type="text" name="elevasi_normal">

        <label>Puncak Bendungan:</label>
        <input type="text" name="puncak_bendungan">

        <label>Debit:</label>
        <input type="text" name="debit">

        <label>Debit Hilir:</label>
        <input type="text" name="debit_hilir">

        <label>Tanggal Surat:</label>
        <input type="text" name="tgl_surat" placeholder="Contoh: 17 Juni 2025">

        <h4>PERKIRAAN POTENSI DAERAH TERDAMPAK</h4>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kampung/Perumahan</th>
                    <th>Kelurahan/Desa</th>
                    <th>Kecamatan</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><input type="text" name="kampung<?= $i ?>"></td>
                    <td><input type="text" name="desa<?= $i ?>"></td>
                    <td><input type="text" name="kecamatan<?= $i ?>"></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <div class="note">
            (apabila jumlah kampung cukup banyak, dapat dicantumkan pada lampiran)
        </div>

        <button type="submit">Kirim</button>
    </form>
</body>
</html>