<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminLTE - Peta</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">

    <!-- Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #map {
            height: 400px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">AdminLTE Map</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-map"></i>
                                <p>Map</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">Map Management</h1>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div id="map"></div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <form id="markerForm">
                                <h3>Tambah Marker</h3>
                                <input type="text" id="markerName" class="form-control" placeholder="Nama Lokasi" required />
                                <input type="text" id="markerLat" class="form-control" placeholder="Latitude" required />
                                <input type="text" id="markerLng" class="form-control" placeholder="Longitude" required />
                                <button type="submit" class="btn btn-primary mt-2">Tambah Marker</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form id="polygonForm">
                                <h3>Tambah Poligon</h3>
                                <textarea id="polygonCoords" class="form-control" placeholder="Koordinat Poligon (JSON)" required></textarea>
                                <button type="submit" class="btn btn-primary mt-2">Tambah Poligon</button>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <table class="table table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data dari database akan dimuat di sini -->
                                </tbody>
                            </table>
                            <table class="table table-striped" id="datapolygon">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Koordinat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data dari database akan dimuat di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AdminLTE Script -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>

    <script>
        const map = L.map('map').setView([-8.65, 115.22], 10); 
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Tambahkan marker dengan klik peta
        map.on('click', function (e) {
            const { lat, lng } = e.latlng;
            const name = prompt("Masukkan nama lokasi untuk marker ini:");
            if (name) {
                fetch("{{ url('api/markers') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name,
                        latitude: lat,
                        longitude: lng
                    }),
                })
                .then((res) => res.json())
                .then(() => {
                    alert("Marker berhasil ditambahkan!");
                    loadData();
                    loadMapData();
                });
            }

        });

        // Event untuk menambahkan marker
        document.getElementById("markerForm").addEventListener("submit", function (e) {
            e.preventDefault();

            // Ambil data dari form
            const name = document.getElementById("markerName").value;
            const lat = parseFloat(document.getElementById("markerLat").value);
            const lng = parseFloat(document.getElementById("markerLng").value);

            // Kirim data ke server
            fetch("{{ url('api/markers') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name,
                    latitude: lat,
                    longitude: lng
                }),
            })
            .then((res) => res.json())
            .then((data) => {
                alert("Marker berhasil ditambahkan!");

                // Tambahkan marker ke peta tanpa perlu reload
                L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(name)
                    .openPopup();

                // Reset form
                document.getElementById("markerForm").reset();

                // Update tabel data
                loadData();
            });
        });

        // Fungsi untuk memuat marker dan poligon ke peta
        function loadMapData() {
            fetch("{{ url('api/markers') }}")
                .then((res) => res.json())
                .then((data) => {
                    data.forEach((item) => {
                        if (item.latitude && item.longitude) {
                            L.marker([item.latitude, item.longitude])
                                .addTo(map)
                                .bindPopup(item.name);
                        }
                    });
                });

            fetch("{{ url('api/polygons') }}")
                .then((res) => res.json())
                .then((data) => {
                    data.forEach((item, index) => {
                        const coords = JSON.parse(item.coordinates);
                        L.polygon(coords)
                            .addTo(map)
                            .bindPopup(`Poligon ${index + 1}`);
                    });
                });
        }

        // Fungsi untuk memuat data ke tabel
        function loadData() {
            fetch("/api/markers")
                .then((res) => res.json())
                .then((data) => {
                    const markerTableBody = document.querySelector('#dataTable tbody');
                    markerTableBody.innerHTML = '';
                    data.forEach((item, index) => {
                        markerTableBody.innerHTML += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.name}</td>
                                <td>${item.latitude}</td>
                                <td>${item.longitude}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="zoomToMarker(${item.latitude}, ${item.longitude})">View Map</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteItem(${item.id}, 'marker')">Hapus</button>
                                </td>
                            </tr>
                        `;
                    });
                });



            fetch("/api/polygons")
    .then((res) => res.json())
    .then((data) => {
        const polygonTableBody = document.querySelector('#datapolygon tbody');
        polygonTableBody.innerHTML = '';
        data.forEach((item, index) => {
            const coords = JSON.parse(item.coordinates);
            polygonTableBody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${JSON.stringify(coords)}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="zoomToPolygon(${item.id})">View Map</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteItem(${item.id}, 'polygon')">Hapus</button>
                    </td>
                </tr>
            `;
        });
    });

        }

        // Fungsi untuk menghapus data
        function deleteItem(id, type) {
            const url = type === 'marker'
                ? `/api/markers/${id}` // Koreksi URL
                : `/api/polygons/${id}`;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then((res) => {
                if (!res.ok) {
                    throw new Error(`Gagal menghapus data. Status: ${res.status}`);
                }
                return res.json();
            })
            .then((response) => {
                alert(response.message || 'Data berhasil dihapus!');
                loadData();
                loadMapData();
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus data: ' + error.message);
            });
        }

        //Fungsi Zoom Marker
        function zoomToMarker(lat, lng) {
            map.setView([lat, lng], 15); // Zoom ke marker dengan zoom level 15
            L.popup()
                .setLatLng([lat, lng])
                .setContent("You are here!")
                .openOn(map);
        }

        //Fungsi Zoom Polygon
        function zoomToPolygon(id) {
            fetch(`/api/polygons/${id}`)
                .then((res) => res.json())
                .then((data) => {
                    const coords = JSON.parse(data.coordinates);

                    // Buat polygon dari koordinat dan zoom ke area polygon
                    const polygon = L.polygon(coords, { color: 'blue' }).addTo(map);
                    map.fitBounds(polygon.getBounds());
                    
                    // Tambahkan popup atau highlight jika diperlukan
                    polygon.bindPopup(`Polygon ID: ${id}`).openPopup();
                })
                .catch((error) => {
                    console.error("Error loading polygon:", error);
                    alert("Gagal menampilkan polygon. Silakan coba lagi.");
                });
        }


        // Event untuk menambahkan poligon
        document.getElementById("polygonForm").addEventListener("submit", function (e) {
            e.preventDefault();

            try {
                const coords = JSON.parse(document.getElementById("polygonCoords").value);

                fetch("{{ url('api/polygons') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        coordinates: JSON.stringify(coords)
                    }),
                })
                .then((res) => {
                    if (!res.ok) {
                        throw new Error(`Server error: ${res.status}`);
                    }
                    return res.json();
                })
                .then((data) => {
                    alert("Poligon berhasil ditambahkan!");

                    // Tambahkan poligon ke peta tanpa reload
                    L.polygon(coords)
                        .addTo(map)
                        .bindPopup('Poligon baru');

                    // Reset form
                    document.getElementById("polygonForm").reset();

                    // Update tabel data
                    loadData();
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                });
            } catch (error) {
                alert('Format JSON tidak valid. Harap periksa koordinat Anda.');
            }
        });

        // Inisialisasi data awal
        loadData();
        loadMapData();
    </script>
</body>

</html>
