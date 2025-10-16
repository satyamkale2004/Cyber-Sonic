<?php
// update_profile.php
session_start();
header("Content-Type: application/json");
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit();
}
$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"), true);
$full_name = trim($data['full_name'] ?? '');
$phone     = trim($data['phone'] ?? '');
$address   = trim($data['address'] ?? '');

// If your user_profiles.user_id is unique, you can use INSERT ON DUPLICATE KEY
// Make sure you have a UNIQUE KEY on user_id in user_profiles table
// Example:
// ALTER TABLE user_profiles ADD UNIQUE KEY (user_id);

$sql = "
    INSERT INTO user_profiles (user_id, full_name, phone, address)
    VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
      full_name = VALUES(full_name),
      phone = VALUES(phone),
      address = VALUES(address)
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $user_id, $full_name, $phone, $address);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
$stmt->close();
$conn->close();
?>
