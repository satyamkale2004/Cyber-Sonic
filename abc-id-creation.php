<?php
session_start();
include 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?showLoginModal=1");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName']);

    // Insert only the text details into the database
    $stmt = $conn->prepare("INSERT INTO abc_id_creation (user_id, full_name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $fullName);

    if ($stmt->execute()) {
        $message = "ABC ID created successfully!";
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
    <title>ABC ID Creation - Cyber Sonic</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="abc.css">
</head>
<body>
    <h1>ABC ID Creation</h1>
    <p>Welcome to our ABC ID Creation service. Please fill in the details below to create your ID.</p>

    <?php if ($message): ?>
        <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Note: File inputs are retained only for frontend display. Their "name" attributes have been removed so they are not submitted. -->
    <form method="POST" action="abc-id-creation.php" enctype="multipart/form-data">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required><br><br>
        
        <label for="identityProof">Identity Proof (Aadhaar Card, Pan Card):</label>
        <input type="file" id="identityProof"><br><br>
        
        <label for="addressProof">Address Proof:</label>
        <input type="file" id="addressProof"><br><br>
        
        <button type="submit">Submit</button>
    </form>
    <br><br><br><br><br><br><br><br>

    <!-- Footer -->
    <footer>
        &copy; 2025 Cyber Sonic. All rights reserved. | <a href="index.php">Home</a>
    </footer>
</body>
</html>
