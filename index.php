<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="Leaflet.markercluster-1.4.1/dist/MarkerCluster.css">
    <link rel="stylesheet" href="Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css">
    <script src="Leaflet.markercluster-1.4.1/dist/leaflet.markercluster-src.js"></script>
    <script src="Leaflet.markercluster-1.4.1/src/MarkerCluster.js"></script>
    <script src="locations.js"></script>
    <style>
    #map {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geo Location</title>
</head>

<body>
    <div id="map">

    </div>
    <script>
    // processMap(locations)
    fetch('koneksi.php')
        .then(response => response.json())
        .then(data => {
            // Proses data yang diterima
            var locations = data;
            processMap(locations)
            // console.log(data)
            // Kode Anda untuk menambahkan marker dan bindPopup
            // ...
        }).catch(error => {
            console.error('Error:', error);
        });

    function processMap(locations) {
        var map = L.map('map').setView([-6.164356293420007, 106.81486322462246], 5);
        L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=ITIXxb2Z7RgtGpaS1fuS', {
            attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'
        }).addTo(map);

        // Buat polygon
        // var polygon = L.polygon(locations.polygon).addTo(map);
        console.log(locations)
        // console.log(locations.polygon)

        var markers = L.markerClusterGroup();
        // Tambahkan marker ke peta
        var locationsData = locations.features;
        locationsData.forEach(function(location) {
            var coordinates = location.geometry.coordinates;
            var kecamatan = location.properties.Kecamatan;

            if (location.geometry.type == 'MultiPolygon') {
                coordinates.forEach(function(polygon) {
                    polygon.forEach(function(ring) {
                        ring.forEach(function(coord) {
                            var marker = L.marker(new L.LatLng(coord[1], coord[0]));
                            marker.bindPopup('<strong>Kabupaten:</strong> ' +
                            kabupaten);
                            markers.addLayer(marker);
                        });
                    });
                });
            }

            if (location.geometry.type == 'Polygon') {
                coordinates.forEach(function(ring) {
                    ring.forEach(function(coord) {
                        var marker = L.marker(new L.LatLng(coord[1], coord[0]));
                        marker.bindPopup('<strong>Kabupaten:</strong> ' + kabupaten);
                        markers.addLayer(marker);
                    });
                })
            }

            if (location.geometry.type == 'Point') {
                console.log(location.geometry);
                coordinates.forEach(function(ring) {
                    ring.forEach(function(coord) {
                        var marker = L.marker(new L.LatLng(coord[1], coord[0]));
                        marker.bindPopup('<strong>Kecamatan:</strong> ' + kecamatan);
                        markers.addLayer(marker);
                    });
                })
            }
        });

        map.addLayer(markers);
    }
    </script>
</body>

</html>