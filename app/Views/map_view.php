<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Leaflet Map with OSRM Routing</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css') ?>">
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
    </style>
</head>

<body>

    <div class="locate-control" onclick="showMyLocation()" title="Lokasi Saya">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#333" viewBox="0 0 24 24">
            <path d="M12 10a2 2 0 102.001 2.001A2.002 2.002 0 0012 10zm10 1h-2.071a8.004 8.004 0 00-6.929-6.929V2a1 1 0 10-2 0v2.071A8.004 8.004 0 004.071 11H2a1 1 0 100 2h2.071a8.004 8.004 0 006.929 6.929V22a1 1 0 102 0v-2.071a8.004 8.004 0 006.929-6.929H22a1 1 0 100-2zM12 18a6 6 0 116-6 6.006 6.006 0 01-6 6z" />
        </svg>
    </div>

    <div class="sidebar" id="sidebar">
        <h3>Menu Peta</h3>
        <ul>
            <li>
                <label>
                    <input type="checkbox" id="checkboxGenangan" checked />
                    Layer Genangan
                </label>
                <ul class="gradeGroup">
                    <li><label><input type="checkbox" class="gradeFilter" value="1" checked /> GradeCode 1</label></li>
                    <li><label><input type="checkbox" class="gradeFilter" value="2" checked /> GradeCode 2</label></li>
                    <li><label><input type="checkbox" class="gradeFilter" value="3" checked /> GradeCode 3</label></li>
                    <li><label><input type="checkbox" class="gradeFilter" value="4" checked /> GradeCode 4</label></li>
                    <li><label><input type="checkbox" class="gradeFilter" value="5" checked /> GradeCode 5</label></li>
                </ul>
            </li>
            <li>
                <label><input type="checkbox" id="checkboxDas" checked> Layer DAS</label>
            </li>
            <li>
                <label><input type="checkbox" id="checkboxSungai" checked> Layer Sungai</label>
            </li>
            <li><label><input type="checkbox" id="checkboxJalurEvakuasi" checked> Jalur Evakuasi</label></li>
            <li><label><input type="checkbox" id="checkboxTitikEvakuasi" checked> Titik Evakuasi</label></li>
            <li><label><input type="checkbox" id="checkboxTitikTinjau" checked> Titik Tinjau</label></li>
        </ul>
    </div>

    <button id="toggleSidebar" onclick="toggleSidebar()">≡</button>
    <div id="map" style="height: 100vh;"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        const map = L.map('map').setView([-8.740373, 116.777827], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let genanganLayer, originalData, dasLayer, sungaiLayer, jalurEvakuasiLayer, titikEvakuasiLayer, titikTinjauLayer;

        fetch('<?= base_url("public/assets/geojson/Genangan.json") ?>')
            .then(response => response.json())
            .then(data => {
                originalData = data;
                updateFilteredLayer();
            });

        fetch('<?= base_url("public/assets/geojson/das.json") ?>')
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

        fetch('<?= base_url("public/assets/geojson/sungai.json") ?>')
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

        fetch('<?= base_url("public/assets/geojson/Jalur_Evakuasi.json") ?>')
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



        fetch('<?= base_url("public/assets/geojson/Titik_Evakuasi.json") ?>')
            .then(res => res.json())
            .then(data => {
                titikEvakuasiLayer = L.geoJSON(data, {
                    pointToLayer: (feature, latlng) => {
                        return L.marker(latlng, {
                            icon: L.icon({
                                iconUrl: '<?= base_url("public/assets/img/evakuasi.png") ?>',
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


        fetch('<?= base_url("public/assets/geojson/titik_tinjau.json") ?>')
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

        const mainGenanganCheckbox = document.getElementById('checkboxGenangan');
        mainGenanganCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            gradeCheckboxes.forEach(cb => {
                cb.checked = isChecked;
                cb.disabled = !isChecked;
            });
            updateFilteredLayer();
        });

        function getFillColor(grade) {
            switch (parseInt(grade)) {
                case 1:
                    return '#003366';
                case 2:
                    return '#336699';
                case 3:
                    return '#6699cc';
                case 4:
                    return '#99ccff';
                case 5:
                    return '#cce6ff';
                default:
                    return 'lightblue';
            }
        }

        function updateFilteredLayer() {
            const layerOn = mainGenanganCheckbox.checked;
            const selectedGrades = Array.from(gradeCheckboxes).filter(cb => cb.checked).map(cb => cb.value);

            if (genanganLayer) map.removeLayer(genanganLayer);
            if (!layerOn) return;

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
    </script>
</body>

</html>