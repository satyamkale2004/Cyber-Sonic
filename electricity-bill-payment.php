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
    $consumerID = trim($_POST['consumerID']);
    $subDivisionCode = intval($_POST['subDivisionCode']); // Name updated to remove spaces

    $stmt = $conn->prepare("INSERT INTO electricity_bill_payment (user_id, consumer_id, sub_division_code) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $consumerID, $subDivisionCode);

    if ($stmt->execute()) {
        $message = "Electricity bill payment details submitted successfully!";
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
  <title>Electricity Bill Payment - Cyber Sonic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="electricity.css">
</head>
<body>
  <h1>Electricity Bill Payment</h1>
  <p>Welcome to our Electricity Bill Payment service. Please fill in the required details to proceed with your payment.</p>
  
  <?php if ($message): ?>
    <p style="color:green; font-weight:bold;"><?php echo $message; ?></p>
  <?php endif; ?>

  <form method="POST" action="electricity-bill-payment.php">
      <label for="consumerID">Consumer ID:</label>
      <input type="text" id="consumerID" name="consumerID" required><br><br>
      
      <label for="subDivisionCode">Sub Division Code:</label>
      <input type="number" id="subDivisionCode" name="subDivisionCode" required><br><br>
      
      <button type="submit">Submit</button>
  </form>
  <footer>
      &copy; 2025 Cyber Sonic. All rights reserved. | <a href="index.php">Home</a>
  </footer>
</body>
</html>
