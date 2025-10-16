<?php
$conn = new mysqli("localhost", "root", "Hrushi@2005", "cyber_sonic");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$service = $_POST['service'];
$date = $_POST['date'];
$time = $_POST['time'];

$sql = "INSERT INTO records (name, mobile, email, service, date, time) VALUES ('$name', '$mobile', '$email', '$service', '$date', '$time')";
$conn->query($sql);

header("Location: dashboard.html");
?>
