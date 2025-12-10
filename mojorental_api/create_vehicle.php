<?php
// htdocs/mojorental/api/create_vehicle.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'koneksi.php';

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$name = $data['name'];
$brand = $data['brand'];
$plate = $data['plate_number'];
$price = $data['price_per_day'];
$type = $data['type'];

$sql = "INSERT INTO vehicles (name, brand, plate_number, price_per_day, type, status) VALUES (?, ?, ?, ?, ?, 'available')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssds", $name, $brand, $plate, $price, $type);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}
?>