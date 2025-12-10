<?php
// htdocs/mojorental/api/rentals.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'koneksi.php';

$user_id = $_GET['user_id'] ?? 0;

// JOIN tabel rentals dengan vehicles supaya nama kendaraan muncul
$sql = "SELECT rentals.*, vehicles.name as vehicle_name, vehicles.brand 
        FROM rentals 
        JOIN vehicles ON rentals.vehicle_id = vehicles.id 
        WHERE rentals.user_id = ? 
        ORDER BY rentals.id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>