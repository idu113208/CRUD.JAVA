<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/Tracer.php';

$database = new Database();
$db = $database->getConnection();
$tracer = new Tracer($db);

$stmt = $tracer->getAllForMap();
$num = $stmt->rowCount();

$angkatan_filter = isset($_GET['angkatan']) ? $_GET['angkatan'] : null;
$prodi_filter = isset($_GET['prodi']) ? $_GET['prodi'] : null;

if($num > 0) {
    $data_arr = array();
    $data_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        // Simple PHP filtering (Ideal is SQL WHERE)
        if($angkatan_filter && $angkatan != $angkatan_filter) continue;
        if($prodi_filter && $program_studi != $prodi_filter) continue;

        $item = array(
            "id_tracer" => $id_tracer,
            "nama" => $nama,
            "angkatan" => $angkatan,
            "program_studi" => $program_studi,
            "instansi" => $instansi,
            "jabatan" => $jabatan,
            "lat" => $latitude,
            "lng" => $longitude
        );
        array_push($data_arr["records"], $item);
    }
    echo json_encode($data_arr);
} else {
    echo json_encode(array("message" => "Tidak ada data.", "records" => []));
}
?>