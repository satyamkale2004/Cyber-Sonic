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
    $fullName          = trim($_POST['fullName']);
    $contactDetails    = trim($_POST['contactDetails']);
    $departureLocation = trim($_POST['departureLocation']);
    $destination       = trim($_POST['destination']);
    $travellingDate    = $_POST['travellingdate'];
    $travellingTime    = $_POST['travellingtime'];

    // Insert into train_ticket_booking
    $stmt = $conn->prepare("
        INSERT INTO train_ticket_booking (
            user_id,
            full_name,
            contact_details,
            departure_location,
            destination,
            travelling_date,
            travelling_time
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "issssss",
        $user_id,
        $fullName,
        $contactDetails,
        $departureLocation,
        $destination,
        $travellingDate,
        $travellingTime
    );

    if ($stmt->execute()) {
        $message = "Train ticket booked successfully!";
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
  <title>Train Ticket Booking - Cyber Sonic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="train.css">
</head>
<body>
  <h1>Train Ticket Booking</h1>
  <p>Welcome to our Train Ticket Booking service. Please fill in the details below to book your train ticket.</p>
  
  <?php if ($message): ?>
    <p style="color:green; font-weight:bold;"><?php echo $message; ?></p>
  <?php endif; ?>

  <!-- The file input "photoID" has no name attribute, so it's not stored -->
  <form method="POST" action="train-ticket-booking.php" enctype="multipart/form-data">
      <label for="fullName">Full Name of Member/Members:</label>
      <input type="text" id="fullName" name="fullName" required><br><br>
      
      <label for="contactDetails">Contact Details:</label>
      <input type="text" id="contactDetails" name="contactDetails" required><br><br>
      
      <label for="photoID">Photo ID (For Frontend only):</label>
      <input type="file" id="photoID"><br><br>
      
      <label for="departureLocation">Departure Location:</label>
      <input type="text" id="departureLocation" name="departureLocation" required><br><br>

      <label for="destination">Destination:</label>
      <input type="text" id="destination" name="destination" required><br><br>

      <label for="travellingdate">Date of Travelling:</label>
      <input type="date" id="travellingdate" name="travellingdate" required><br><br>
      
      <label for="travellingtime">Time of Travelling:</label>
      <input type="time" id="travellingtime" name="travellingtime" required><br><br>
      
      <button type="submit">Submit</button>
  </form>
  <footer>
      &copy; 2025 Cyber Sonic. All rights reserved. | <a href="index.php">Home</a>
  </footer>
</body>
</html>
