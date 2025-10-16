<?php
// exam-form-filling.php
session_start();
include 'db_connect.php';

// If not logged in, redirect to index with login modal
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?showLoginModal=1");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Only text fields are inserted; file inputs are for display only
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentName = trim($_POST['studentName']);
    $fatherName  = trim($_POST['fatherName']);
    $motherName  = trim($_POST['motherName']);
    $address     = trim($_POST['Address']);
    $phone       = trim($_POST['Phone']);
    $college     = trim($_POST['College']);

    // Insert textual details into exam_form_filling
    $stmt = $conn->prepare("
        INSERT INTO exam_form_filling (
            user_id,
            student_name,
            father_name,
            mother_name,
            address,
            phone,
            college
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "issssss",
        $user_id,
        $studentName,
        $fatherName,
        $motherName,
        $address,
        $phone,
        $college
    );

    if ($stmt->execute()) {
        $message = "Form submitted successfully!";
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
    <title>Exam Form Filling</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="exam.css">
</head>
<body>
    <!-- Page Title -->
    <h1>Exam Form Filling</h1>
    <p>Welcome to the Exam Form Filling portal. Please enter the required details below.</p>

    <?php if ($message): ?>
        <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Form Section -->
    <form method="POST" action="exam-form-filling.php" enctype="multipart/form-data">
        <label for="studentName">Student Name:</label>
        <input type="text" id="studentName" name="studentName" required><br>
        
        <label for="fatherName">Father's Name:</label>
        <input type="text" id="fatherName" name="fatherName" required><br>
        
        <label for="motherName">Mother's Name:</label>
        <input type="text" id="motherName" name="motherName" required><br>

        <label for="Address">Address:</label>
        <input type="text" id="Address" name="Address" required><br>

        <label for="Phone">Phone:</label>
        <input type="number" id="Phone" name="Phone" required><br>
        
        <!-- The following file inputs remain for display only; no "name" attributes. -->
        <label for="Caste">Caste:</label>
        <input type="file" id="Caste"><br>

        <label for="AadharNO">Aadhar NO.:</label>
        <input type="file" id="AadharNO"><br>
        
        <label for="passportPhoto">Passport Size Photo:</label>
        <input type="file" id="passportPhoto"><br>
        
        <label for="signature">Signature:</label>
        <input type="file" id="signature"><br>

        <label for="College">College:</label>
        <input type="text" id="College" name="College" required><br>
        
        <label for="marksheet10">10th Marksheet:</label>
        <input type="file" id="marksheet10"><br>
        
        <label for="marksheet12">12th Marksheet:</label>
        <input type="file" id="marksheet12"><br>
        
        <label for="marksheetFY">FY Marksheet (If Available):</label>
        <input type="file" id="marksheetFY"><br>
        
        <label for="marksheetSY">SY Marksheet (If Available):</label>
        <input type="file" id="marksheetSY"><br>
        
        <label for="marksheetTY">TY Marksheet (If Available):</label>
        <input type="file" id="marksheetTY"><br>
        
        <button type="submit">Submit</button>
    </form><br><br><br><br><br>

    <!-- Footer -->
    <footer>
        &copy; 2025 Cyber Sonic. All rights reserved. | <a href="index.php">Home</a>
    </footer>
</body>
</html>
