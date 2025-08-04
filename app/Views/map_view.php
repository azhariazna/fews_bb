<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta charset="utf-8" />
    <title>FEWS Tiu Suntuk</title>
    <link rel="icon" type="image/png" href="https://sda.pu.go.id/balai/bbwsnt1/assets/img/favicon.png">


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />

    <style>
        .leaflet-routing-container .leaflet-routing-alt .leaflet-routing-alt-content {
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .leaflet-routing-container-hide>* {
            animation: blink 1s infinite;
        }

        .leaflet-routing-container-hide .leaflet-routing-alt-line {
            stroke: red;
            stroke-width: 4;
            stroke-dasharray: 8, 8;
            animation: blink 1s infinite;
        }

        .gradeGroup {
            margin-left: 20px;
        }

        #topbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background-color: #005a9e;
            color: white;
            z-index: 1001;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 20px;
        }

        .topbar-content {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .topbar-logo {
            height: 42px;
            width: auto;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
            white-space: nowrap;
        }

        @media screen and (max-width: 480px) {
            .topbar-title {
                font-size: 14px;
                white-space: normal;
                max-width: 140px;
            }
        }



        #topbar h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }


        #map {
            position: absolute;
            top: 54px;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .sidebar {
            top: 54px !important;
        }

        .gradeGroup {
            margin-left: 20px;
            transition: all 0.3s ease;
        }

        .gradeGroup.collapsed {
            display: none;
        }

@keyframes blinkPanel {
  0% {
    background-color: #fff5f5;
    border-color: red;
  }
  50% {
    background-color: #ffcccc;
    border-color: transparent;
  }
  100% {
    background-color: #fff5f5;
    border-color: red;
  }
}

#warning-legend {
  display: block !important;
  position: absolute;
  bottom: 65px;
  right: 20px;
  padding: 12px;
  max-width: 250px;
  background-color: #fff;
  border: 2px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}

#topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 16px;
  background-color: #005a9e;
  height: 60px;
  color: white;
}

#topbar .btn {
  font-size: 14px;
  padding: 5px 12px;
}

.leaflet-bottom.leaflet-left {
    bottom: 80px !important; /* Ganti angkanya sesuai seberapa atas yang kamu mau */
}




     .warning-toggle-container {
      position: fixed;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: white;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      z-index: 999;
      max-width: 250px;
    }

    .toggle-label {
      display: block;
      cursor: pointer;
      font-size: 18px;
      font-weight: bold;
      text-align: center;
      background-color: red;
      color: white;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .warning-wrapper {
      display: block;
    }

    #toggleAll:checked ~ .warning-wrapper {
      display: none;
    }

    .warning-box {
      padding: 8px;
      margin-bottom: 10px;
      background-color: #f9f9f9;
      font-size: 14px;
      border-left: 5px solid gray;
    }

    .status-text {
      font-weight: bold;
    }

    .blink {
      animation: blinkText 1s infinite;
    }

    @keyframes blinkText {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.2; }
    }


    #cuacaWrapper {
        z-index: 9999 !important;
    }

    #cuacaContent::-webkit-scrollbar {
        height: 6px;
    }

    #cuacaContent::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 3px;
    }
    #toggleCuaca.fixed-top-right {
    position: fixed;
    bottom: 90px; /* atau 100px jika ingin lebih naik */
    right: 20px;
    z-index: 1050; /* pastikan di atas Leaflet dan komponen lain */
}


#sidebarInfo {
  transition: transform 0.3s ease-in-out;
}

#sidebarInfo.hide {
  transform: translateX(100%);
}

#toggleInfo {
  z-index: 1100;
}



    </style>
    <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="overflow-x: hidden;">

        


<nav id="topbar" class="navbar navbar-expand-lg navbar-dark shadow-sm rounded-bottom px-3"
     style="height: 60px; background-color: #0068ff !important;">

    <div class="container-fluid h-100">
        <!-- Logo dan Judul -->
        <a class="navbar-brand d-flex align-items-center gap-2 flex-nowrap" href="#">
        <img src="assets/img/pu.png" alt="Logo" class="img-fluid" style="height: 36px;">
        
        <!-- Tambahkan di sini -->
        <div class="d-none d-sm-block text-white fw-bold lh-sm" style="font-size: 1rem;">
            <div>DASHBOARD MONITORING</div>
            <div>EARLY WARNING SYSTEM</div>
            <div style="font-size: 0.95rem;">BENDUNGAN TIU SUNTUK</div>
        </div>
        </a>


        <!-- Toggle untuk Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopbar" aria-controls="navbarTopbar" aria-expanded="false" aria-label="Toggle navigation" style="background-color: blue;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Utama -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarTopbar">
            <ul class="navbar-nav align-items-lg-center gap-lg-3 mb-2 mb-lg-0">
            <a class="nav-link" style="font-size: 0.9rem;" href="<?= base_url('dashboard') ?>" class="text-white fw-bold text-decoration-none">DATA INSTRUMENT</a>


                <!-- DATA SENSOR -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " style="font-size: 0.9rem;" href="#" id="sensorDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       UNDUH DATA SENSOR
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sensorDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('dashboard?menu=logger-range') ?>">BENDUNGAN TIU SUNTUK</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('dashboard?menu=data-awlr') ?>">AWLR</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('dashboard?menu=data-avwr') ?>">AVWR</a></li>
                    </ul>
                </li>

                                <!-- DATA SENSOR -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " style="font-size: 0.9rem;" href="#" id="sensorDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        HASIL SIMULASI
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sensorDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('dashboard?menu=simulasi') ?>">BENDUNGAN</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('dashboard?menu=simulasi-awlr') ?>">AWLR</a></li>
                    </ul>
                </li>

                <!-- RTD -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" style="font-size: 0.9rem;" href="#" id="rtdDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        RTD
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="rtdDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('dashboard?rtd=isi') ?>">Isi RTD</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('dashboard?rtd=download') ?>">Download RTD</a></li>
                    </ul>
                </li>

                <a class="nav-link" style="font-size: 0.9rem;" href="<?= base_url('dashboard?menu=manual-tma') ?>" class="text-white fw-bold text-decoration-none">INPUT TMA MANUAL</a>
            </ul>

            <!-- LOGIN / SIDEBAR -->
            <div class="d-flex align-items-center ms-lg-3 gap-2">
                <?php if (session()->get('logged_in')): ?>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            👤 <?= session()->get('username') ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                <?php endif; ?>



            </div>
        </div>
    </div>
</nav>


            <button id="toggleSidebar" onclick="toggleSidebar()" 
                class="btn btn-outline-primary btn-sm position-fixed" 
                style="top: 9%; right: 10px; z-index: 1100;" 
                title="Tampilkan Info">
                <i class="fa-circle">i</i>
            </button>


<div id="alert-sakra" class="banjir-alert-box position-absolute" style="top: 17%; left: 10px; z-index:999;">
  <div class="alert alert-secondary p-2" id="evakuasi-alert">
    <strong>⚠️ Status Evakuasi</strong><br>
    <span id="status-sakra-title"></span><br>
    <small id="statusevakuasi">-</small>
  </div>
</div>


 

    

<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Arahkan ke controller Login::auth -->
      <form action="<?= base_url('login/auth') ?>" method="post">
        <?= csrf_field() ?> <!-- Ini yang penting untuk CSRF -->
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login Dashboard</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Login</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>





    <div class="locate-control" onclick="showMyLocation()" title="Lokasi Saya">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#333" viewBox="0 0 24 24">
            <path d="M12 10a2 2 0 102.001 2.001A2.002 2.002 0 0012 10zm10 1h-2.071a8.004 8.004 0 00-6.929-6.929V2a1 1 0 10-2 0v2.071A8.004 8.004 0 004.071 11H2a1 1 0 100 2h2.071a8.004 8.004 0 006.929 6.929V22a1 1 0 102 0v-2.071a8.004 8.004 0 006.929-6.929H22a1 1 0 100-2zM12 18a6 6 0 116-6 6.006 6.006 0 01-6 6z" />
        </svg>
    </div>

<div class="sidebar" id="sidebar" style="font-size: 0.7rem; padding: 6px 10px; width: 240px; background-color: #f8f9fa; border: 1px solid #ccc; border-radius: 6px;">
    <!-- Tombol X -->
 

<h6 style="font-size: 0.85rem; font-weight: bold; margin-bottom: 4px;">Info</h6>
    <ul class="list-unstyled" style="margin-bottom: 0; padding-left: 0;">
        <?php if (session()->get('logged_in')): ?>
            <li style="margin-bottom: 2px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkboxSungai" checked>
                    <label class="form-check-label" for="checkboxSungai">Layer Sungai</label>
                </div>
            </li>
            <li style="margin-bottom: 2px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkboxJalurEvakuasi" checked>
                    <label class="form-check-label" for="checkboxJalurEvakuasi">Jalur Evakuasi</label>
                </div>
            </li>
            <li style="margin-bottom: 2px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkboxTitikTinjau" checked>
                    <label class="form-check-label" for="checkboxTitikTinjau">Titik Tinjau</label>
                </div>
            </li>
            <li style="margin-bottom: 2px;">
                <div class="form-check d-flex align-items-center">
                    <input class="form-check-input me-1" type="checkbox" id="checkboxAwlr" checked>
                    <img src="assets/img/tma.png" alt="TMA Icon" width="14" height="14" class="me-1">
                    <label class="form-check-label" for="checkboxAwlr">AWLR</label>
                </div>
            </li>
        <?php endif; ?>

        <li style="margin-bottom: 2px;">
            <label style="cursor: pointer;" onclick="toggleGradeGroup()">Genangan</label>
            <ul class="list-unstyled ps-2 mt-1" id="gradeGroup" style="font-size: 0.7rem; margin-bottom: 0;">
                <li>
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input me-1 gradeFilter" type="checkbox" value="1" checked>
                        <span style="width:12px;height:12px;background-color:#cce6ff;border:1px solid #333;border-radius:4px;margin-right:4px;"></span>
                        <label class="form-check-label">Aman</label>
                    </div>
                </li>
                <li>
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input me-1 gradeFilter" type="checkbox" value="2" checked>
                        <span style="width:12px;height:12px;background-color:#99ccff;border:1px solid #333;border-radius:4px;margin-right:4px;"></span>
                        <label class="form-check-label">Waspada</label>
                    </div>
                </li>
                <li>
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input me-1 gradeFilter" type="checkbox" value="3" checked>
                        <span style="width:12px;height:12px;background-color:#336699;border:1px solid #333;border-radius:4px;margin-right:4px;"></span>
                        <label class="form-check-label">Awas</label>
                    </div>
                </li>
                <!-- <li>
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input me-1 gradeFilter" type="checkbox" value="4" checked>
                        <span style="width:12px;height:12px;background-color:#003366;border:1px solid #333;border-radius:4px;margin-right:4px;"></span>
                        <label class="form-check-label">&gt; 4 m</label>
                    </div>
                </li> -->
            </ul>
        </li>

        <li style="margin-bottom: 2px;">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkboxDas" checked>
                <label class="form-check-label" for="checkboxDas">Layer DAS</label>
            </div>
        </li>

        <li style="margin-bottom: 0;">
            <div class="form-check d-flex align-items-center">
                <input class="form-check-input me-1" type="checkbox" id="checkboxTitikEvakuasi" checked>
                <img src="assets/img/evakuasi.png" alt="Evakuasi Icon" width="14" height="14" class="me-1">
                <label class="form-check-label" for="checkboxTitikEvakuasi">Titik Evakuasi</label>
            </div>
        </li>
    </ul>
</div>




       
    
<body>

<div class="warning-toggle-container" style="font-size: 0.65rem;">
  <input type="checkbox" id="toggleAll" style="display:none;">
  <label for="toggleAll" class="toggle-label" style="font-size: 0.6rem; padding: 2px 6px;">!</label>

  <div class="warning-wrapper">
        <!-- CARD 1 -->
    <div class="card mb-1 shadow-sm border-info" style="font-size: 0.65rem;">
      <div class="card-body py-1 px-2">
        <h6 class="card-title mb-1 text-info fw-bold" style="font-size: 0.7rem;">BENDUNGAN BINTANG BANO</h6>
        <div>
            Status: Aman </br>
          <!-- Status: <span id="status-a" class="status-text badge" style="font-size: 0.65rem;">-</span><br> -->
          <!-- TMA: <span id="tma-a" class="fw-bold">-</span> m -->
           TMA: 112.99 m
        </div>
      </div>
    </div>

    <!-- CARD 1 -->
    <div class="card mb-1 shadow-sm border-info" style="font-size: 0.65rem;">
      <div class="card-body py-1 px-2">
        <h6 class="card-title mb-1 text-info fw-bold" style="font-size: 0.7rem;">BENDUNGAN TIU SUNTUK</h6>
        <div>
          Status: <span id="status-a" class="status-text badge" style="font-size: 0.65rem;">-</span><br>
          TMA: <span id="tma-a" class="fw-bold">-</span> m
        </div>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="card mb-1 shadow-sm border-info" style="font-size: 0.65rem;">
      <div class="card-body py-1 px-2">
        <h6 class="card-title mb-1 text-info fw-bold" style="font-size: 0.7rem;">AWLR SAMPIR</h6>
        <div>
          Status: <span id="status-b" class="status-text badge" style="font-size: 0.65rem;">-</span><br>
          TMA: <span id="tma-b" class="fw-bold">-</span> m
        </div>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="card mb-1 shadow-sm border-info" style="font-size: 0.65rem;">
      <div class="card-body py-1 px-2">
        <h6 class="card-title mb-1 text-info fw-bold" style="font-size: 0.7rem;">AWLR MENEMENG</h6>
        <div>
          Status: <span id="status-c" class="status-text badge" style="font-size: 0.65rem;">-</span><br>
          TMA: <span id="tma-c" class="fw-bold">-</span> m
        </div>
      </div>
    </div>
  </div>
</div>





    
    <div id="map" style="height: 88vh;"></div>


<!-- WRAPPER CUACA + TOGGLE BUTTON -->
<div id="cuacaWrapper" class="position-absolute bottom-0 start-50 translate-middle-x mb-1 z-3 w-100 px-2" style="font-size: 0.7rem; max-width: 100vw; overflow-x: auto;">
    <!-- Tombol Toggle -->
    <div class="d-flex justify-content-end mb-1 px-2">
        <button id="toggleCuaca" class="btn btn-outline-primary btn-sm rounded-pill shadow" style="font-size: 0.65rem; padding: 2px 8px;">
            Tampilkan / Sembunyikan Cuaca
        </button>
    </div>

    <!-- Isi Prakiraan Cuaca -->
    <div id="cuacaContent" class="d-flex flex-row flex-nowrap overflow-auto bg-white bg-opacity-90 rounded shadow p-1 gap-1" style="pointer-events: auto;">
        <?php foreach ($cuacaList as $periode): ?>
            <?php foreach ($periode as $item): ?>
                <div class="card flex-shrink-0 text-center" style="min-width: 110px;">
                    <div class="card-body p-1">
                        <small class="text-muted" style="font-size: 0.65rem;"><?= $item['local_datetime'] ?></small>
                        <h6 class="mb-1" style="font-size: 0.7rem;"><?= $item['weather_desc'] ?></h6>
                        <img src="<?= $item['image'] ?>" alt="cuaca" width="22" height="22">
                        <p class="mb-0" style="font-size: 0.65rem;"><small>Suhu: <?= $item['t'] ?>°C</small></p>
                        <p class="mb-0" style="font-size: 0.65rem;"><small>Kelembaban: <?= $item['hu'] ?>%</small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>









    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Paling akhir sebelum </body> -->
<script>


document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleCuaca");
    const cuacaContent = document.getElementById("cuacaContent");

    console.log("Script loaded!");
    if (toggleBtn && cuacaContent) {
        console.log("Tombol ditemukan.");

        toggleBtn.addEventListener("click", function () {
            console.log("Tombol diklik");
            cuacaContent.classList.toggle("d-none");

            toggleBtn.innerText = cuacaContent.classList.contains("d-none")
                ? "Tampilkan Cuaca"
                : "Sembunyikan Cuaca";
        });
    } else {
        console.error("Elemen toggle atau cuacaContent tidak ditemukan!");
    }
});
</script>




</body>

    <script>
     // Data TMA dari sistem (misalnya dari AJAX/telemetri)
    const tmaData = {
        A: <?= esc($tmaData['suntuk'])?>,
        B: <?= esc($tmaData['sampir'])/100?>,
        C: <?= esc($tmaData['menemeng'])/100?>
    };

    document.addEventListener("DOMContentLoaded", function () {
   // Ambil nilai TMA dari PHP
  const tmaSampir = tmaData.B;
  console.log("TMA Sampir:");
  // Tetapkan threshold
  const thresholds = { waspada: 10.5, siaga: 11, awas: 11.5 };

  // Identifikasi elemen
  const statusEvakuasi = document.getElementById("statusevakuasi");
  const alertBox = document.getElementById("evakuasi-alert");
  const statusTitle = document.getElementById("status-sakra-title");

  let status = "-";

  if (tmaSampir >= thresholds.awas) {
    status = "Awas";
  } else if (tmaSampir >= thresholds.siaga) {
    status = "Siaga";
  } else if (tmaSampir >= thresholds.waspada) {
    status = "Waspada";
  } else {
    status = "Aman";
  }

  let evakuasiText = "-";
  let alertClass = "alert alert-secondary p-2";

  switch (status.toLowerCase()) {
    case "aman":
      evakuasiText = "Tidak ada evakuasi";
      alertClass = "alert alert-success p-2";
      break;
    case "siaga":
      evakuasiText = "Belum evakuasi, pemantauan dan persiapan";
      alertClass = "alert alert-warning p-2";
      break;
    case "waspada":
      evakuasiText = "Evakuasi terbatas / bersiap";
      alertClass = "alert alert-info p-2";
      break;
    case "awas":
      evakuasiText = "Evakuasi menyeluruh / wajib";
      alertClass = "alert alert-danger p-2";
      break;
  }

  if (statusEvakuasi) statusEvakuasi.textContent = evakuasiText;
  if (statusTitle) statusTitle.textContent =  status;
  if (alertBox) alertBox.className = alertClass;
});



    function updateStatus(tma, batas, statusEl, tmaEl) {
        let status = "Aman";
        let color = "green";

        if (tma >= batas.siaga && tma < batas.awas) {
        status = "Siaga";
        color = "orange";
        } else if (tma >= batas.waspada && tma < batas.siaga) {
        status = "Waspada";
        color = "goldenrod";
        } else if (tma >= batas.awas) {
        status = "Awas";
        color = "red";
        }

        statusEl.textContent = status;
        statusEl.style.color = color;
        statusEl.classList.remove("blink");
        if (status !== "Aman") statusEl.classList.add("blink");

        tmaEl.textContent = tma.toFixed(2);
    }

    // Set status untuk tiap bendungan
    updateStatus(
        tmaData.A,
        { waspada: 94.75, siaga: 95.5, awas: 97 },
        document.getElementById("status-a"),
        document.getElementById("tma-a")
    );

    updateStatus(
        tmaData.B,
        { waspada: 10.5, siaga: 11, awas: 11.5 },
        document.getElementById("status-b"),
        document.getElementById("tma-b")
    );

    updateStatus(
        tmaData.C,
        { waspada: 7, siaga: 7.5, awas: 8 },
        document.getElementById("status-c"),
        document.getElementById("tma-c")
    );


   // Inisialisasi peta
    map = L.map('map').setView([-8.7941986,116.93022], 11); // gunakan ulang variabel


    // Definisi tile layers
    var openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map); // default aktif

    var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: '&copy; Google Satellite'
    });

    var esriImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '&copy; Esri World Imagery'
    });

    // Tambahkan kontrol pemilihan base layer
    var baseMaps = {
        "OpenStreetMap": openStreetMap,
        "Google Satellite": googleSat,
        "Esri World Imagery": esriImagery
    };

    L.control.layers(baseMaps, null, {
        position: 'bottomleft'
    }).addTo(map);







        const layerOn = true; // atau false jika default ingin disembunyikan



        let genanganLayer, originalData, dasLayer, sungaiLayer, jalurEvakuasiLayer, titikEvakuasiLayer, titikTinjauLayer;

        fetch('assets/geojson/Genangan.json')
            .then(response => response.json())
            .then(data => {
                originalData = data;
                updateFilteredLayer();
            });

        fetch('assets/geojson/das.json')
            .then(res => res.json())
            .then(data => {
                dasLayer = L.geoJSON(data, {
                    style: {
                        color: 'green',
                        weight: 2,
                        fillOpacity: 0.1
                    }
                });
                if (document.getElementById("checkboxDas")?.checked) {
                    dasLayer.addTo(map);
                }
            });

        fetch('assets/geojson/sungai.json')
            .then(res => res.json())
            .then(data => {
                sungaiLayer = L.geoJSON(data, {
                    style: {
                        color: 'grey',
                        weight: 1.5
                    }
                });
                if (document.getElementById("checkboxSungai")?.checked) {
                    sungaiLayer.addTo(map);
                }
            });

        fetch('assets/geojson/Jalur_Evakuasi.json')
            .then(res => res.json())
            .then(data => {
                jalurEvakuasiLayer = L.geoJSON(data, {
                    style: {
                        color: 'orange',
                        weight: 3,
                        dashArray: '6,4'
                    }
                });
                if (document.getElementById("checkboxJalurEvakuasi")?.checked) {
                    jalurEvakuasiLayer.addTo(map);
                }
            });



        fetch('assets/geojson/titik_evakuasi.json')
        .then(res => res.json())
        .then(data => {
            titikEvakuasiLayer = L.geoJSON(data, {
                pointToLayer: (feature, latlng) => {
                    return L.marker(latlng, {
                        icon: L.icon({
                            iconUrl: 'assets/img/evakuasi.png',
                            iconSize: [24, 24]
                        })
                    });
                },
                onEachFeature: (feature, layer) => {
                    const props = feature.properties;

                    layer.bindPopup(`
                        <h5> <b>Kecamatan: ${props.KECAMATAN}</b><br> </h5>
                         <h5> <b>Desa:${props.DESA}<br>  </b>  </h5>
                        <b>Koordinat (UTM):</b>
                        x: ${props.x}
                        y: ${props.y}<br><br>
                        <button onclick="navigateTo(${feature.geometry.coordinates[1]}, ${feature.geometry.coordinates[0]})">
                            🔄 Ke Lokasi
                        </button>
                    `);
                }
            });

            titikEvakuasiLayer.addTo(map);
        });


        fetch('assets/geojson/Titik_Tinjau.json')
            .then(res => res.json())
            .then(data => {
                titikTinjauLayer = L.geoJSON(data, {
                    pointToLayer: (f, latlng) => L.circleMarker(latlng, {
                        radius: 6,
                        fillColor: 'purple',
                        color: 'white',
                        weight: 1,
                        fillOpacity: 0.8
                    }),
                    onEachFeature: (f, l) => l.bindPopup("Titik Tinjau")
                });
                if (document.getElementById("checkboxTitikTinjau")?.checked) {
                    titikTinjauLayer.addTo(map);
                }
            });

        document.getElementById("checkboxJalurEvakuasi")?.addEventListener("change", function() {
            if (jalurEvakuasiLayer) {
                this.checked ? map.addLayer(jalurEvakuasiLayer) : map.removeLayer(jalurEvakuasiLayer);
            }
        });
        document.getElementById("checkboxTitikEvakuasi")?.addEventListener("change", function() {
            if (titikEvakuasiLayer) {
                this.checked ? map.addLayer(titikEvakuasiLayer) : map.removeLayer(titikEvakuasiLayer);
            }
        });
        document.getElementById("checkboxTitikTinjau")?.addEventListener("change", function() {
            if (titikTinjauLayer) {
                this.checked ? map.addLayer(titikTinjauLayer) : map.removeLayer(titikTinjauLayer);
            }
        });

        document.getElementById("checkboxDas")?.addEventListener("change", function() {
            if (dasLayer) {
                this.checked ? map.addLayer(dasLayer) : map.removeLayer(dasLayer);
                if (genanganLayer) genanganLayer.bringToFront();
            }
        });

        document.getElementById("checkboxSungai")?.addEventListener("change", function() {
            if (sungaiLayer) {
                this.checked ? map.addLayer(sungaiLayer) : map.removeLayer(sungaiLayer);
                if (genanganLayer) genanganLayer.bringToFront();
            }
        });

        const gradeCheckboxes = document.querySelectorAll('.gradeFilter');

        gradeCheckboxes.forEach(cb => cb.addEventListener('change', updateFilteredLayer));



        function getFillColor(grade) {
            switch (parseInt(grade)) {
                case 1:
                    return '#cce6ff';
                case 2:
                    return '#99ccff';
                case 3:
                    return '#336699';
                case 4:
                    return '#003366';
                case 5:
                    return '#cce6ff';
                default:
                    return 'lightblue';
            }
        }

        function updateFilteredLayer() {
            const selectedGrades = Array.from(gradeCheckboxes).filter(cb => cb.checked).map(cb => cb.value);

            if (genanganLayer) map.removeLayer(genanganLayer);
            if (selectedGrades.length === 0) return;

            genanganLayer = L.geoJSON(originalData, {
                filter: feature => selectedGrades.includes(String(feature.properties.gridcode)),
                style: feature => ({
                    color: 'blue',
                    fillColor: getFillColor(feature.properties.gridcode),
                    fillOpacity: 0.4,
                    weight: 0.5
                }),
                onEachFeature: (feature, layer) => {
                    const popupContent = Object.entries(feature.properties).map(([k, v]) => `<strong>${k}</strong>: ${v}`).join('<br>');
                    layer.bindPopup(popupContent);
                }
            }).addTo(map);

            genanganLayer.bringToFront();
        }

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.style.display = (sidebar.style.display === "none") ? "block" : "none";
        }

        let lokasiMarker = null,
            watchId = null;

        function showMyLocation() {
            if (!navigator.geolocation) return alert("Geolocation tidak didukung.");

            navigator.geolocation.getCurrentPosition(function(position) {
                const latlng = [position.coords.latitude, position.coords.longitude];

                if (lokasiMarker) map.removeLayer(lokasiMarker);

                lokasiMarker = L.circleMarker(latlng, {
                    radius: 8,
                    fillColor: "red",
                    color: "white",
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.9
                }).addTo(map).bindPopup(`<b>Lokasi Saya</b><br>${latlng.join(', ')}`).openPopup();

                map.setView(latlng, 14);
            });
        }

        function startLiveTracking() {
            if (watchId) return;
            if (!navigator.geolocation) return alert("Tidak mendukung pelacakan lokasi.");

            watchId = navigator.geolocation.watchPosition(pos => {
                const latlng = [pos.coords.latitude, pos.coords.longitude];
                if (lokasiMarker) map.removeLayer(lokasiMarker);

                lokasiMarker = L.circleMarker(latlng, {
                    radius: 8,
                    fillColor: "red",
                    color: "white",
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.9
                }).addTo(map).bindPopup("Lokasi Saya").openPopup();

                map.setView(latlng, 14);
            });
        }

        function stopLiveTracking() {
            if (watchId) navigator.geolocation.clearWatch(watchId);
            watchId = null;
        }


        let routingControl;

        function navigateToEvakuasi() {
            if (!navigator.geolocation) return alert("Geolocation tidak didukung.");

            navigator.geolocation.getCurrentPosition(function(position) {
                const current = L.latLng(position.coords.latitude, position.coords.longitude);

                if (routingControl) map.removeControl(routingControl);

                routingControl = L.Routing.control({
                    waypoints: [current, L.latLng(evakuasiLatLng)],
                    lineOptions: {
                        styles: [{
                            color: 'red',
                            weight: 4,
                            dashArray: '10,10'
                        }]
                    },
                    createMarker: () => null,
                    router: new L.Routing.OSRMv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                    }),
                    routeWhileDragging: false
                }).addTo(map);
            });
        }

        function navigateTo(lat, lng) {
            const targetLatLng = L.latLng(lat, lng);

            if (!navigator.geolocation) {
                alert("Geolocation tidak didukung.");
                return;
            }

            navigator.geolocation.getCurrentPosition(function(position) {
                const currentLatLng = L.latLng(position.coords.latitude, position.coords.longitude);

                if (routingControl) map.removeControl(routingControl);

                routingControl = L.Routing.control({
                    waypoints: [currentLatLng, targetLatLng],
                    lineOptions: {
                        styles: [{
                            color: 'red',
                            weight: 4,
                            dashArray: '10,10'
                        }]
                    },
                    createMarker: () => null,
                    router: new L.Routing.OSRMv1({
                        serviceUrl: 'https://router.project-osrm.org/route/v1'
                    }),
                    routeWhileDragging: false
                }).addTo(map);
            });
        }
        let telemetriLayer = null;

        fetch('api/telemetri')
            .then(res => res.json())
            .then(data => {
                // Buat layer tapi belum langsung ditambahkan ke peta
                telemetriLayer = L.geoJSON(data, {
                    pointToLayer: (feature, latlng) => {
                        return L.marker(latlng, {
                            icon: L.icon({
                                iconUrl: 'assets/img/tma.png',
                                iconSize: [24, 24],
                                iconAnchor: [12, 12],
                                popupAnchor: [0, -12]
                            })
                        });
                    },
                    onEachFeature: (feature, layer) => {
                        const props = feature.properties;
                        const idTelemetri = props.id;

                        const canvasId = `chart-${idTelemetri}`;
                        const popupContent = `
                            <strong>${props.nama_lokasi}</strong><br>
                            Waktu: ${props.waktu}<br>
                            TMA: ${props.tma} cm<br><br>
                            <div style="width: 450px; height: 300px;">
                                <canvas id="${canvasId}" width="420" height="250"></canvas>
                            </div>
                        `;


                        layer.bindPopup(popupContent, {
                            maxWidth: 500,
                            autoPan: true,
                            autoPanPadding: [20, 20]
                        });


                    layer.on('popupopen', () => {
                        fetch(`api/grafik/${idTelemetri}`)
                            .then(res => res.json())
                            .then(response => {
                                const grafik = response.data || [];

                                const ctx = document.getElementById(canvasId).getContext('2d');

                                let waktuUpdate = 'Data tidak tersedia';
                                if (grafik.length > 0 && grafik[0].update_at) {
                                    waktuUpdate = grafik[0].update_at;
                                }

                                new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: grafik.map(g => `Jam ${g.jam}`),
                                        datasets: [
                                            {
                                                label: 'Debit Prediksi (m³/dt)',
                                                data: grafik.map(g => g.debit_prediksi),
                                                borderColor: 'blue',
                                                backgroundColor: 'blue',
                                                pointRadius: 2,
                                                borderWidth: 1,
                                                fill: false,
                                                tension: 0.4
                                            },
                                            {
                                                label: 'TMA Aktual (m³/dt)',
                                                data: grafik.map(g => g.tma_aktual),
                                                borderColor: 'red',
                                                backgroundColor: 'red',
                                                pointRadius: 2,
                                                borderWidth: 1,
                                                fill: false,
                                                tension: 0.4
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: false,
                                        plugins: {
                                            legend: {
                                                display: true,
                                                labels: {
                                                    boxWidth: 12,
                                                    font: { size: 10 }
                                                }
                                            },
                                            title: {
                                                display: true,
                                                text: `Hidrograf Prediksi Banjir (Update: ${waktuUpdate})`,
                                                font: { size: 14 },
                                                padding: { top: 5, bottom: 10 }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                ticks: {
                                                    autoSkip: true,
                                                    maxTicksLimit: 12,
                                                    font: { size: 10 }
                                                }
                                            },
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Debit (m³/dt)'
                                                }
                                            }
                                        }
                                    }
                                });


                            });

                    });





                    }


                });

                // Cek status awal checkbox
                if (document.getElementById("checkboxAwlr")?.checked) {
                    telemetriLayer.addTo(map);
                }

                // Tambahkan event untuk toggle layer
                document.getElementById("checkboxAwlr")?.addEventListener("change", function() {
                    if (this.checked) {
                        map.addLayer(telemetriLayer);
                    } else {
                        map.removeLayer(telemetriLayer);
                    }
                });
    });

        function toggleGradeGroup() {
            const group = document.getElementById("gradeGroup");
            const arrow = document.getElementById("arrowToggle");
            if (group && arrow) {
                group.classList.toggle("collapsed");
                arrow.textContent = group.classList.contains("collapsed") ? "▶" : "▼";
            }
        }

        // 1. Tambah ikon khusus
        const iconTiuSuntuk = L.icon({
            iconUrl: 'assets/img/bendungan.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        const iconBintangBano = L.icon({
            iconUrl: 'assets/img/bendungan.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });



            let bintangBanoMarker;

            // === Marker Bendungan Tiu Suntuk ===
            fetch('/telemetri/tiusuntuk')
            .then(res => res.json())
            .then(data => {
                const content = `<b>Bendungan Tiu Suntuk</b><br>TMA: ${data.tma} m<br>Waktu: ${data.waktu}`;
                const marker = L.marker([-8.7941986,116.93022], {
                icon: iconTiuSuntuk
                }).addTo(map)
                .bindTooltip(content, {
                    permanent: false,
                    direction: "top"
                }).openTooltip();
            });

            // === Marker Bendungan Bintang Bano ===
            fetch('/telemetri/latest')
            .then(res => res.json())
            .then(data => {
                const content = `<b>Bendungan Bintang Bano</b><br>TMA: ${data.tma} m<br>Waktu: ${data.waktu}`;
                const marker = L.marker([-8.713588, 116.989053], {
                icon: iconBintangBano
                }).addTo(map)
                .bindTooltip(content, {
                    permanent: false,
                    direction: "top"
                }).openTooltip();
            });




        // 3. Zoom ke dua lokasi
        const group = new L.featureGroup([tiuSuntukMarker, bintangBanoMarker]);
        map.fitBounds(group.getBounds().pad(1));



          function toggleWarningBox() {
            const wrapper = document.querySelector('.warning-toggle-container');
            if (wrapper) {
            const checkbox = wrapper.querySelector('#toggleAll');
            if (checkbox) checkbox.checked = !checkbox.checked;
            }
        }


document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebarInfo");
    const toggleBtn = document.getElementById("toggleInfo");
    const closeBtn = document.getElementById("closeInfo");

    // Sembunyikan sidebar di awal
    sidebar.classList.add("hide");

    // Tampilkan sidebar ketika tombol info ditekan
    toggleBtn.addEventListener("click", () => {
        sidebar.classList.remove("hide");
        toggleBtn.style.display = "none";
    });

    // Sembunyikan sidebar ketika tombol ✕ ditekan
    closeBtn.addEventListener("click", () => {
        sidebar.classList.add("hide");
        toggleBtn.style.display = "block";
    });
});






</script>

</html>