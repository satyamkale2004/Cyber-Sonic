<?php
$conn = new mysqli("localhost", "root", "Hrushi@2005", "cyber_sonic");

$id = $_POST['id'];
$name = $_POST['name'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$service = $_POST['service'];
$date = $_POST['date'];
$time = $_POST['time'];

$sql = "UPDATE records SET name='$name', mobile='$mobile', email='$email', service='$service', date='$date', time='$time' WHERE id=$id";
$conn->query($sql);

header("Location: dashboard.html");
?>
