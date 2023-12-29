<?php
// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'geolocation');

function getData() {
    // Ambil data dari database
    $koneksi = mysqli_connect('localhost', 'root', '', 'geolocation');

    $query = "SELECT a.*, b.name AS 'kecamatan', b.lat AS 'latitude', b.long FROM visit a JOIN kec b ON a.kd_kec = b.id";
    $result = mysqli_query($koneksi, $query);
    
    $features = [];
    // var_dump($result);die;
    while($row = mysqli_fetch_assoc($result)) {
        $feature = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    "coordinates" => [
                        [
                            [$row['long'], $row['latitude']]
                        ]
                    ]
                ],  // Misalkan kolom geometri Anda adalah 'geometry_column'
                'properties' => [
                    'Kecamatan' => ucwords($row['kecamatan']) // Misalkan kolom propinsi Anda adalah 'propinsi_column'
                    // ... tambahkan properti lainnya sesuai kebutuhan
                ],
            ];
    
            $features[] = $feature;
    }
    
    $data = [
        'type' => 'FeatureCollection',
        'features' => $features,
        // 'polygon' => $polygon
    ];
    
    header('Content-Type: application/json');
    echo json_encode($data);
}


getData()
?>
