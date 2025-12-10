<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'koneksi.php';

// Ambil semua rental, JOIN dengan user dan vehicle untuk dapat nama penyewa & nama mobil
$sql = "SELECT rentals.*, 
               users.name as user_name, users.phone, 
               vehicles.name as vehicle_name, vehicles.plate_number 
        FROM rentals 
        JOIN users ON rentals.user_id = users.id 
        JOIN vehicles ON rentals.vehicle_id = vehicles.id 
        ORDER BY rentals.id DESC";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>