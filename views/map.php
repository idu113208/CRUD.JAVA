<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peta Persebaran Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map { height: 500px; width: 100%; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h3>Peta Persebaran Alumni</h3>

        <div class="card mb-3">
            <div class="card-body">
                <form class="row g-3" id="filterForm">
                    <div class="col-auto">
                        <input type="text" class="form-control" id="angkatan" placeholder="Angkatan (contoh: 2018)">
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control" id="prodi" placeholder="Program Studi">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary mb-3" onclick="initMap()">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="map"></div>
        <a href="../index.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>

    <!-- Gunakan placeholder API Key atau ganti dengan KEY Anda -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
    <script>
        var map;
        var markers = [];

        function initMap() {
            var centerMap = {lat: -6.200000, lng: 106.816666}; // Jakarta
            if(!map) {
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 5,
                    center: centerMap
                });
            }

            // Clear markers
            markers.forEach(m => m.setMap(null));
            markers = [];

            var angkatan = document.getElementById('angkatan').value;
            var prodi = document.getElementById('prodi').value;

            var url = '../controllers/MapController.php?';
            if(angkatan) url += '&angkatan=' + angkatan;
            if(prodi) url += '&prodi=' + prodi;

            // Fetch data from PHP Controller
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if(data.records) {
                        data.records.forEach(alumni => {
                            if(alumni.lat && alumni.lng) {
                                var marker = new google.maps.Marker({
                                    position: {lat: parseFloat(alumni.lat), lng: parseFloat(alumni.lng)},
                                    map: map,
                                    title: alumni.nama
                                });

                                var contentString = `
                                    <div>
                                        <h5>${alumni.nama}</h5>
                                        <p><strong>Angkatan:</strong> ${alumni.angkatan}</p>
                                        <p><strong>Prodi:</strong> ${alumni.program_studi}</p>
                                        <p><strong>Instansi:</strong> ${alumni.instansi}</p>
                                        <p><strong>Jabatan:</strong> ${alumni.jabatan}</p>
                                    </div>
                                `;

                                var infowindow = new google.maps.InfoWindow({
                                    content: contentString
                                });

                                marker.addListener('click', function() {
                                    infowindow.open(map, marker);
                                });

                                markers.push(marker);
                            }
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>