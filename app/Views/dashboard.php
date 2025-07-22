<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Tambahkan tombol toggle sidebar untuk mobile -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="nav-link">Login sebagai: <strong><?= session()->get('username') ?></strong></span>
      </li>
      <li class="nav-item">
        <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm nav-link">Logout</a>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="#" class="brand-link text-center">
      <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item">
            <a href="admin" class="nav-link" target="content-frame">
              <i class="nav-icon fas fa-home"></i>
              <p>Home</p>
            </a>
          </li>

            <!-- Dropdown Menu RTD -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Data Sensor
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview pl-3">
              <li class="nav-item">
                <a href="logger-range" class="nav-link" target="content-frame" id="menu-isi-rtd">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bendungan Tiu Suntuk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="data-awlr" class="nav-link" target="content-frame" id="menu-download-rtd">
                  <i class="far fa-circle nav-icon"></i>
                  <p>AWLR</p>
                </a>
              </li>
            </ul>
          </li>



          <li class="nav-item">
            <a href="<?php echo base_url('/')?>" class="nav-link">
              <i class="nav-icon fas fa-map"></i>
              <p>Dashboard Peta</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="manual-tma" class="nav-link" target="content-frame">
              <i class="nav-icon fas fa-keyboard"></i>
              <p>Input Manual TMA</p>
            </a>
          </li>

                <!-- Dropdown Menu RTD -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Menu RTD
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview pl-3">
              <li class="nav-item">
                <a href="laporanrtd" class="nav-link" target="content-frame" id="menu-isi-rtd">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Isi RTD</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="laporanrtd/download" class="nav-link" target="content-frame" id="menu-download-rtd">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Download RTD</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Konten -->
  <div class="content-wrapper">
    <div class="content pt-3 px-3">
      <iframe id="content-frame" name="content-frame" style="width:100%; height:90vh; border:none;"></iframe>
    </div>
  </div>

</div>

<!-- Script JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
  // Tentukan default target
  let target = "admin";

  // Baca parameter URL
  const params = new URLSearchParams(window.location.search);
  if (params.has("rtd")) {
    const val = params.get("rtd");
    if (val === "isi") target = "laporanrtd";
    if (val === "download") target = "laporanrtd/download";
  }

    if (params.has("menu")) {
      const menu = params.get("menu");
      if (menu === "manual-tma") target = "manual-tma";
      if (menu === "data-awlr") target = "data-awlr";
      if (menu === "logger-range") target = "logger-range";
    }

  // Set iframe src sesuai target
  document.getElementById("content-frame").src = target;
</script>
</body>
</html>
