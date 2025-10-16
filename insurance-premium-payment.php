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
    $fullName     = trim($_POST['fullName']);
    $policyNumber = trim($_POST['policyNumber']);
    $emailID      = trim($_POST['emailid']);
    $idProof      = trim($_POST['idProof']);
    $birthDate    = $_POST['birthdate'];

    $stmt = $conn->prepare("
        INSERT INTO insurance_premium_payment (
            user_id,
            full_name,
            policy_number,
            email_id,
            id_proof,
            birth_date
        ) VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssss", $user_id, $fullName, $policyNumber, $emailID, $idProof, $birthDate);

    if ($stmt->execute()) {
        $message = "Insurance premium payment details submitted successfully!";
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
  <title>Insurance Premium Payment - Cyber Sonic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="insurance.css">
</head>
<body>
  <h1>Insurance Premium Payment</h1>
  <p>Fill in the details below to make your insurance premium payment.</p>
  
  <?php if ($message): ?>
    <p style="color:green; font-weight:bold;"><?php echo $message; ?></p>
  <?php endif; ?>

  <form method="POST" action="insurance-premium-payment.php">
      <label for="fullName">Full Name:</label>
      <input type="text" id="fullName" name="fullName" required><br><br>

      <label for="policyNumber">Insurance Policy Number:</label>
      <input type="text" id="policyNumber" name="policyNumber" required><br><br>

      <label for="emailid">Email-ID:</label>
      <input type="text" id="emailid" name="emailid" required><br>

      <label for="idProof">Valid ID Proof (Aadhaar, PAN, etc.):</label>
      <input type="text" id="idProof" name="idProof" required><br><br>

      <label for="birthdate">Date Of Birth :</label>
      <input type="date" id="birthdate" name="birthdate" required><br><br>

      <button type="submit">Submit</button>
  </form>
  <footer>
      &copy; 2025 Cyber Sonic. All rights reserved. | <a href="index.php">Home</a>
  </footer>
</body>
</html>
