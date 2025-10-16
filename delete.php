<?php
$conn = new mysqli("localhost", "root", "Hrushi@2005", "cyber_sonic");

$id = $_POST['id'];

$sql = "DELETE FROM records WHERE id=$id";
$conn->query($sql);

header("Location: dashboard.html");
?>
