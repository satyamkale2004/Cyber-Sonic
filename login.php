<?php
session_start();
include 'db_connect.php';

// If already logged in, redirect to index.php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            // Redirect to index.php so the user remains on home
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Cyber Sonic</title>
  <style>
    body { font-family: Arial, sans-serif; }
    .container { max-width: 400px; margin: 50px auto; }
    form label { display: block; margin-bottom: 6px; font-weight: bold; }
    form input { width: 100%; padding: 8px; margin-bottom: 12px; box-sizing: border-box; }
    form button { width: 100%; padding: 10px; background: #3498db; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    form button:hover { background: #2980b9; }
    .error { color: red; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <?php if($error): ?>
      <p class="error"><?php echo $error; ?></p>
      <p><a href="index.php?showLoginModal=1">Go back</a></p>
    <?php endif; ?>
    <!-- If login fails, user sees error and link to return -->
  </div>
</body>
</html>
