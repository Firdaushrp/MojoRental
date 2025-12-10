<?php
// htdocs/mojorental/api/create_rental.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'koneksi.php';

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$user_id = $data['user_id'];
$vehicle_id = $data['vehicle_id'];
$start = $data['start_date'];
$end = $data['end_date'];
$days = $data['total_days'];
$price = $data['total_price'];
$notes = $data['notes'] ?? '-';

$sql = "INSERT INTO rentals (user_id, vehicle_id, start_date, end_date, total_days, total_price, notes, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissids", $user_id, $vehicle_id, $start, $end, $days, $price, $notes);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}
?>