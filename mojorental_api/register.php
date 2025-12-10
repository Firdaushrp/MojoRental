<?php
// htdocs/mojorental/api/register.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'koneksi.php';

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$phone = $data['phone'] ?? '';
$ktp = $data['ktp_number'] ?? '';
$address = $data['address'] ?? '';

if (empty($name) || empty($email) || empty($password) || empty($ktp)) {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
    exit();
}

// Cek Email Kembar
$check = $conn->query("SELECT id FROM users WHERE email = '$email'");
if ($check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email sudah terdaftar"]);
    exit();
}

$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (name, email, password, phone, ktp_number, address) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $hashed_pass, $phone, $ktp, $address);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Registrasi berhasil"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal: " . $stmt->error]);
}
?>