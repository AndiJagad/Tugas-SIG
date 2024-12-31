<!DOCTYPE html>
<html>

<head>
    <title>Maps Display</title>
    <!-- Leaflet.js CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>

</head>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4lKVb0eLSNyhEO-C_8JoHhAvba6aZc3U"></script>

<body>
    <!-- Div untuk Leaflet Map -->
    <div id="leaflet-map" style="height: 400px; margin-bottom: 20px;"></div>
    <!-- Div untuk Google Map -->
    <div id="googleMap" style="height: 400px;"></div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Leaflet Map
            const leafletMap = L.map('leaflet-map').setView([-8.7961228, 115.1735968], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(leafletMap);

            // Leaflet Routing
            const startPoint = L.latLng(-8.7961228, 115.1735968);
            const endPoint = L.latLng(-8.794123, 115.182347);
            L.Routing.control({
                waypoints: [startPoint, endPoint],
                routeWhileDragging: true
            }).addTo(leafletMap);

            // Google Maps
            const googleMap = new google.maps.Map(document.getElementById("googleMap"), {
                center: {
                    lat: -8.7961228,
                    lng: 115.1735968
                },
                zoom: 13
            });

            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();

            directionsRenderer.setMap(googleMap);

            // Directions Request
            const request = {
                origin: {
                    lat: -8.7961228,
                    lng: 115.1735968
                },
                destination: {
                    lat: -8.794123,
                    lng: 115.182347
                },
                travelMode: google.maps.TravelMode.DRIVING
            };

            directionsService.route(request, (result, status) => {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(result);
                } else {
                    console.error(`Error fetching directions: ${status}`);
                }
            });
        });
    </script>
</body>

</html>
