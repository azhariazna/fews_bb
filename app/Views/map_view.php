<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta charset="utf-8" />
    <title>FEWS Tiu Suntuk</title>

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
    </style>
    <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
        <div id="topbar">
        <div class="topbar-content" style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
            <div class="d-flex align-items-center">
            <img src="assets/img/pu.png" alt="Logo" class="topbar-logo">
            <span class="topbar-title">DASHBOARD MONITORING</span>             
            </div>
            <div class="d-flex align-items-center gap-2">   
                 <?php if (session()->get('logged_in')): ?>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        👤 <?= session()->get('username') ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="<?= base_url('laporanrtd') ?>">Isi RTD</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('laporanrtd/download') ?>">Download RTD</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('manual-tma') ?>">Input TMA Bendungan Tiu Suntuk</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-end gap-2 w-100" style="position: absolute; top: 10px; left: 0; right: 0; z-index: 1001; padding: 0 10px;">
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <?php endif; ?>     
                <button id="toggleSidebar" class="btn btn-primary" onclick="toggleSidebar()">☰</button>
            </div>

            </div>
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
    <div class="sidebar" id="sidebar">
        <h3>Menu</h3>
        <ul>
        <?php if (session()->get('logged_in')): ?>
            <li>
                <label><input type="checkbox" id="checkboxSungai" > Layer Sungai</label>
            </li>

            <li>
                <label>
                    <input type="checkbox" id="checkboxJalurEvakuasi" >
                    Jalur Evakuasi
                </label>
            </li>

             <li><label><input type="checkbox" id="checkboxTitikTinjau" > Titik Tinjau</label></li>

            <li>
                <label>
                    <input type="checkbox" id="checkboxAwlr" >
                    <img src="assets/img/tma.png" alt="TMA Icon" width="16" height="16" style="vertical-align: middle; margin-right: 5px;">
                    AWLR
                </label>
            </li>

        <?php endif; ?>



            <li>
                <label>
                    <label style="cursor: pointer;" onclick="toggleGradeGroup()">
                        <!-- <input type="checkbox" id="checkboxGenangan" checked /> -->
                        <span id="arrowToggle" style="display: inline-block; width: 16px;">▼</span>
                        Tinggi Genangan
                    </label>
                    <ul class="gradeGroup" id="gradeGroup">
                        <li>
                            <label>
                                <input type="checkbox" class="gradeFilter" value="1" checked />
                                <span style="
                                    display:inline-block;
                                    width:16px !important;
                                    height:16px !important;
                                    margin: 0 6px;
                                    vertical-align: middle;
                                    border: 2px solid #333;
                                    border-radius: 4px;
                                    background-color: #cce6ff;">
                                </span>
                                0–0.5 meter
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" class="gradeFilter" value="2" checked />
                                <span style="
                                    display:inline-block;
                                    width:16px !important;
                                    height:16px !important;
                                    margin: 0 6px;
                                    vertical-align: middle;
                                    border: 2px solid #333;
                                    border-radius: 4px;
                                    background-color: #99ccff;">
                                </span>
                                0.5–1.5 meter
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" class="gradeFilter" value="3" checked />
                                <span style="
                                    display:inline-block;
                                    width:16px !important;
                                    height:16px !important;
                                    margin: 0 6px;
                                    vertical-align: middle;
                                    border: 2px solid #333;
                                    border-radius: 4px;
                                    background-color: #336699;">
                                </span>
                                1.5–4 meter
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" class="gradeFilter" value="4" checked />
                                <span style="
                                    display:inline-block;
                                    width:16px !important;
                                    height:16px !important;
                                    margin: 0 6px;
                                    vertical-align: middle;
                                    border: 2px solid #333;
                                    border-radius: 4px;
                                    background-color: #003366;">
                                </span>
                                > 4 meter
                            </label>
                        </li>
                    </ul>

            </li>
            <li>
                <label><input type="checkbox" id="checkboxDas" checked> Layer DAS</label>
            </li>



            <li>
                <label>
                    <input type="checkbox" id="checkboxTitikEvakuasi" checked>
                    <img src="assets/img/evakuasi.png" alt="Jalur Icon" width="16" height="16" style="vertical-align: middle; margin-right: 5px;">
                    Titik Evakuasi
                </label>
            </li>

           

        </ul>
    </div>

       
    
<body>

<div class="warning-toggle-container">
  <input type="checkbox" id="toggleAll" style="display:none;">
  <label for="toggleAll" class="toggle-label">!</label>

  <div class="warning-wrapper">
    <div class="warning-box">
      <strong>BENDUNGAN TIU SUNTUK</strong><br>
      Status: <span id="status-a" class="status-text">-</span><br>
      TMA: <span id="tma-a">-</span> m
    </div>

    <div class="warning-box">
      <strong>AWLR SAMPIR</strong><br>
      Status: <span id="status-b" class="status-text">-</span><br>
      TMA: <span id="tma-b">-</span> m
    </div>

    <div class="warning-box">
      <strong>AWLR MENEMENG</strong><br>
      Status: <span id="status-c" class="status-text">-</span><br>
      TMA: <span id="tma-c">-</span> m
    </div>
  </div>
</div>





    
    <div id="map" style="height: 100vh;"></div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



</body>

    <script>
     // Data TMA dari sistem (misalnya dari AJAX/telemetri)
    const tmaData = {
        A: <?= esc($tmaData['suntuk'])?>,
        B: <?= esc($tmaData['sampir'])/100?>,
        C: <?= esc($tmaData['menemeng'])/100?>
    };

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
    map = L.map('map').setView([-8.8, 117.8], 9); // gunakan ulang variabel


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
                        }).bindPopup(`
                    <b>${feature.properties?.name || 'Titik Evakuasi'}</b><br>
                    <button onclick="navigateTo(${latlng.lat}, ${latlng.lng})">🔄 Ke Lokasi</button>
                `);
                    }
                });

                // Tambahkan layer ke peta secara eksplisit
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
</script>

</html>