<!DOCTYPE html>
<html>
<head>
    <title>Input Manual TMA - Tiu Suntuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Input Manual TMA - Bendungan Tiu Suntuk</h4>
        </div>
        <div class="card-body">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="/manual-tma/save" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="waktu" class="form-label">Waktu</label>
                    <input type="datetime-local" class="form-control" name="waktu" id="waktu" required>
                </div>

                <div class="mb-3">
                    <label for="tma" class="form-label">TMA (mdpl)</label>
                    <input type="number" step="0.01" class="form-control" name="tma" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset()); // GMT + lokal
        const formatted = now.toISOString().slice(0, 16); // YYYY-MM-DDTHH:MM
        document.getElementById("waktu").value = formatted;
    });
</script>
</body>
</html>
