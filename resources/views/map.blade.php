<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Layout - Google Maps & Leaflet.js</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwlgebS3bplkEr9NEFBhut66Xo-m4muW4"></script>
    <style>
    /* Gaya dasar */
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
        color: #333;
        line-height: 1.6;
    }

    h1 {
        text-align: center;
        margin: 20px 0;
        font-size: 28px;
        color: #2c3e50;
    }

    p {
        text-align: center;
        font-size: 16px;
        color: #555;
    }

    /* Tata letak container peta */
    .map-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        gap: 20px;
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .map-container p {
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        margin: 5px 0;
        color: #7f8c8d;
    }

    /* Gaya peta */
    .map {
        flex: 1 1 calc(50% - 20px);
        height: 500px; 
        min-width: 500px; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
    }

    /* Hover efek pada map */
    .map:hover {
        transform: scale(1.02);
        transition: all 0.3s ease-in-out;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    /* Responsif */
    @media (max-width: 768px) {
        .map-container {
            flex-wrap: wrap;
        }
        .map {
            flex: 1 1 100%;
            min-width: 300px; 
        }
    }
</style>

</head>
<body>
    <h1>TUGAS SIG</h1>

<div class="map-container">
    <div>
        <p>Google Maps: Lokasi Rektorat Universitas Udayana</p>
        <div id="googleMap" class="map"></div>
    </div>
    <div>
        <p>Leaflet.js: Rektorat Universitas Udayana dan Walikota Denpasar</p>
        <div id="leafletMap" class="map"></div>
    </div>
</div>

<script>
    // Google Maps
    function initGoogleMap() {
        const udayanaRektorat = { lat: -8.7984047, lng: 115.1698715 };
        const map = new google.maps.Map(document.getElementById("googleMap"), {
            zoom: 15,
            center: udayanaRektorat,
        });
        const marker = new google.maps.Marker({
            position: udayanaRektorat,
            map: map,
        });
        const infoWindow = new google.maps.InfoWindow({
            content: "<p>Kantor: Rektorat Universitas Udayana</p>",
        });
        marker.addListener("click", () => {
            infoWindow.open(map, marker);
            map.setCenter(marker.getPosition());  
            map.setZoom(17);  
        });
    }
    initGoogleMap();

    // Leaflet.js
    const udayanaRektorat = [-8.7984047, 115.1698715];
    const leafletMap = L.map('leafletMap').setView(udayanaRektorat, 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(leafletMap);
    const marker = L.marker(udayanaRektorat).addTo(leafletMap);
    marker.bindPopup("<p>Kantor: Rektorat Universitas Udayana</p>");
    marker.on('click', function() {
        leafletMap.setView(marker.getLatLng(), 17);  
    });

    const denpasarLocation = [-8.656042, 115.2137391];
    const denpasarMarker = L.marker(denpasarLocation).addTo(leafletMap);
    denpasarMarker.bindPopup("<p>Kantor: Walikota Denpasar</p>");
    denpasarMarker.on('click', function() {
        leafletMap.setView(denpasarMarker.getLatLng(), 17);  
    });
</script>

</body>
</html>
