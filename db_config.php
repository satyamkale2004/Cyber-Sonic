<?php
$servername = "localhost";
$username = "root";
$password = "May1923ur";
$dbname = "cyber_sonic";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>