<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?showLoginModal=1");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $policyID = trim($_POST['policyID']);
    $dateOfBirth = $_POST['dateOfBirth']; // Updated field name

    $stmt = $conn->prepare("INSERT INTO health_insurance_premium (user_id, policy_id, date_of_birth) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $policyID, $dateOfBirth);

    if ($stmt->execute()) {
        $message = "Health insurance premium renewal details submitted successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Health Insurance Premium - Cyber Sonic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="health.css">
</head>
<body>
  <h1>Health Insurance Premium Renewal</h1>
  <p>Welcome to our Health Insurance Premium Renewal service. Please fill in the details below to renew your premium.</p>
  
  <?php if ($message): ?>
    <p style="color:green; font-weight:bold;"><?php echo $message; ?></p>
  <?php endif; ?>

  <form method="POST" action="health-insurance-premium.php">
      <label for="policyID">Policy ID:</label>
      <input type="text" id="policyID" name="policyID" required><br><br>
      
      <label for="dateOfBirth">Date Of Birth:</label>
      <input type="date" id="dateOfBirth" name="dateOfBirth" required><br><br>
      
      <button type="submit">Submit</button>
  </form>
  <footer>
      &copy; 2025 Cyber Sonic. All rights reserved. | <a href="index.php">Home</a>
  </footer>
</body>
</html>
