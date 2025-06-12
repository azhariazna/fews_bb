<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Leaflet Map with Sidebar</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css') ?>">
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
</head>
<body>

    <!-- Tombol Lokasi Bundar -->
    <div class="locate-control" onclick="showMyLocation()" title="Lokasi Saya">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#333" viewBox="0 0 24 24">
            <path d="M12 10a2 2 0 102.001 2.001A2.002 2.002 0 0012 10zm10 1h-2.071a8.004 8.004 0 00-6.929-6.929V2a1 1 0 10-2 0v2.071A8.004 8.004 0 004.071 11H2a1 1 0 100 2h2.071a8.004 8.004 0 006.929 6.929V22a1 1 0 102 0v-2.071a8.004 8.004 0 006.929-6.929H22a1 1 0 100-2zM12 18a6 6 0 116-6 6.006 6.006 0 01-6 6z"/>
        </svg>
    </div>

    <!-- Sidebar di kanan -->
    <div class="sidebar" id="sidebar">
        <h3>Menu Peta</h3>
        <ul>
            <li>
                <label>
                    <input type="checkbox" id="checkboxGenangan" checked />
                    Layer Genangan
                </label>
            </li>
            <li onclick="alert('Menu lain bisa ditambahkan')">Menu Lain</li>
        </ul>
    </div>

    <!-- Tombol Toggle Sidebar -->
    <button id="toggleSidebar" onclick="toggleSidebar()">&#8801;</button>

    <!-- Peta -->
    <div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine JS -->
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.min.js"></script>

    <script>
        const map = L.map('map').setView([-8.740373, 116.777827], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let genanganLayer;

        // Load GeoJSON
        fetch('<?= base_url("public/assets/geojson/Genangan.json") ?>')
            .then(response => response.json())
            .then(data => {
                genanganLayer = L.geoJSON(data, {
                    style: {
                        color: 'blue',
                        fillColor: 'lightblue',
                        fillOpacity: 0.4,
                        weight: 2
                    },
                    onEachFeature: function (feature, layer) {
                        let popupContent = "";
                        for (const key in feature.properties) {
                            popupContent += `<strong>${key}</strong>: ${feature.properties[key]}<br>`;
                        }
                        layer.bindPopup(popupContent);
                    }
                }).addTo(map);
            })
            .catch(error => console.error('Error loading GeoJSON:', error));

        document.getElementById('checkboxGenangan').addEventListener('change', function () {
            if (this.checked) {
                if (genanganLayer) genanganLayer.addTo(map);
            } else {
                if (genanganLayer) map.removeLayer(genanganLayer);
            }
        });

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.style.display = (sidebar.style.display === "none") ? "block" : "none";
        }

        let lokasiMarker;

        function showMyLocation() {
            if (!navigator.geolocation) {
                alert("Geolocation tidak didukung.");
                return;
            }

            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                if (lokasiMarker) map.removeLayer(lokasiMarker);

                lokasiMarker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(`<b>Lokasi Saya</b><br>Lat: ${lat.toFixed(5)}<br>Lng: ${lng.toFixed(5)}`)
                    .openPopup();

                map.setView([lat, lng], 14);
            }, function () {
                alert("Tidak dapat mengambil lokasi.");
            });
        }

        const evakuasiIcon = L.icon({
            iconUrl: '<?= base_url("public/assets/img/evakuasi.png") ?>',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -28]
        });

        const evakuasiLatLng = [-8.704035, 116.802433];
        const markerEvakuasi = L.marker(evakuasiLatLng, { icon: evakuasiIcon }).addTo(map);

        markerEvakuasi.bindPopup(`
            <b>Pos Evakuasi</b><br>
            <button onclick="navigateToEvakuasi()">🔄 Ke Lokasi</button>
        `);

        let routingControl;

        function navigateToEvakuasi() {
            if (!navigator.geolocation) {
                alert("Geolocation tidak didukung.");
                return;
            }

            navigator.geolocation.getCurrentPosition(function (position) {
                const currentLatLng = L.latLng(position.coords.latitude, position.coords.longitude);

                if (routingControl) {
                    map.removeControl(routingControl);
                }

                routingControl = L.Routing.control({
                    waypoints: [
                        currentLatLng,
                        L.latLng(evakuasiLatLng)
                    ],
                    routeWhileDragging: false,
                    show: false,
                    addWaypoints: false,
                    createMarker: function () { return null; }
                }).addTo(map);
            }, function () {
                alert("Gagal mendapatkan lokasi Anda.");
            });
        }
    </script>

</body>
</html>
