<?php
// register.php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $regPassword = $_POST['regPassword'];

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $error = "Email already registered.";
        $stmt->close();
        $conn->close();
        header("Location: index.php?registration=error&error=" . urlencode($error) . "&showLoginModal=1");
        exit();
    } else {
        $stmt->close(); // close the SELECT statement
        $hashedPass = password_hash($regPassword, PASSWORD_BCRYPT);
        $insert = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $insert->bind_param("ss", $email, $hashedPass);
        if ($insert->execute()) {
            $insert->close();
            $conn->close();
            // Redirect back to index.php with success flag and open login modal
            header("Location: index.php?registration=success&showLoginModal=1");
            exit();
        } else {
            $error = "Error: " . $insert->error;
            $insert->close();
            $conn->close();
            header("Location: index.php?registration=error&error=" . urlencode($error) . "&showLoginModal=1");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Cyber Sonic</title>
  <style>
    /* Fallback styling in case the redirect fails */
    body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
    .message { font-weight: bold; }
    a { color: #3498db; text-decoration: none; }
  </style>
</head>
<body>
  <p class="message">Processing registration...</p>
  <p>If you are not redirected automatically, please <a href="index.php?showLoginModal=1">click here</a>.</p>
</body>
</html>
