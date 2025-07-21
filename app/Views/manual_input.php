<?php
// Ambil data default dari controller
$tma = $tma ?? '';
$waktu = $waktu ?? '';
$id = $id ?? null;
$daftar_bendungan = $daftar_bendungan ?? [];
$bendungan = $bendungan ?? 'Tidak diketahui';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Manual TMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Input Manual - <?= esc($bendungan) ?></h4>
        </div>
        <div class="card-body">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- Form TMA Manual -->
            <form action="<?= $id ? base_url('manual-tma/update/' . $id) : base_url('manual-tma/save') ?>" method="post">
                <?= csrf_field() ?>
                <?php if ($id): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <!-- Pilihan Bendungan -->
                <div class="mb-3">
                    <label for="id" class="form-label">Pilih AWLR</label>
                    <select name="id" id="id" class="form-select" onchange="window.location.href='?id=' + this.value" required>
                        <?php foreach ($daftar_bendungan as $item): ?>
                            <option value="<?= $item['id'] ?>" <?= $id == $item['id'] ? 'selected' : '' ?>>
                                <?= esc($item['nama_lokasi']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Input waktu -->
                <div class="mb-3">
                    <label for="waktu" class="form-label">Waktu</label>
                    <input type="datetime-local" class="form-control" name="waktu" id="waktu"
                        value="<?= $waktu ? date('Y-m-d\TH:i', strtotime($waktu)) : '' ?>" required>
                </div>

                <!-- Input TMA -->
                <div class="mb-3">
                    <label for="tma" class="form-label">TMA (mdpl)</label>
                    <input type="number" step="0.01" class="form-control" name="tma" value="<?= esc($tma) ?>" required>
                </div>

                <button type="submit" class="btn btn-success"><?= $id ? 'Update' : 'Simpan' ?></button>
                <a href="<?= base_url('/manual-tma') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<!-- Auto isi waktu jika kosong -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const waktuInput = document.getElementById("waktu");
        if (!waktuInput.value) {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            waktuInput.value = now.toISOString().slice(0, 16);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</ht