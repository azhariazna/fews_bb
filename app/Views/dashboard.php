<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="laporanrtd" target="content-frame">
                            📝 Isi RTD
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laporanrtd/download" target="content-frame">
                            📥 Download RTD
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Navbar atas -->
            <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom mt-3 mb-4">
                <div class="container-fluid">
                    <span class="navbar-text">
                        Login sebagai: <strong><?= session()->get('username') ?></strong>
                    </span>
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm">Logout</a>
                </div>
            </nav>

            <!-- Dynamic Content -->
            <iframe name="content-frame" src="laporanrtd" style="width:100%; height:75vh; border:none;"></iframe>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
