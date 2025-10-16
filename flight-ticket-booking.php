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
    $fullName       = trim($_POST['fullName']);
    $contact        = trim($_POST['contact']);
    $dateOfBirth    = $_POST['dateofbirth'];
    $flightDetails  = trim($_POST['flightDetails']);
    $travellingDate = $_POST['travellingdate'];
    $travellingTime = $_POST['travellingtime'];

    $stmt = $conn->prepare("
        INSERT INTO flight_ticket_booking (
            user_id,
            full_name,
            contact,
            date_of_birth,
            flight_details,
            travelling_date,
            travelling_time
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("issssss", $user_id, $fullName, $contact, $dateOfBirth, $flightDetails, $travellingDate, $travellingTime);

    if ($stmt->execute()) {
        $message = "Flight ticket booked successfully!";
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
  <title>Flight Ticket Booking - Cyber Sonic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="flight.css">
</head>
<body>
  <h1>Flight Ticket Booking</h1>
  <p>Welcome to our Flight Ticket Booking service. Please fill in the details below to book your flight ticket.</p>
  
  <?php if ($message): ?>
    <p style="color:green; font-weight:bold;"><?php echo $message; ?></p>
  <?php endif; ?>

  <form method="POST" action="flight-ticket-booking.php" enctype="multipart/form-data">
      <label for="fullName">Full Name of Member/Members:</label>
      <input type="text" id="fullName" name="fullName" required><br>
      
      <label for="contact">Contact Details:</label>
      <input type="number" id="contact" name="contact" required><br>

      <label for="dateofbirth">Date of Birth:</label>
      <input type="date" id="dateofbirth" name="dateofbirth" required><br><br>

      <label for="photoid">Valid Photo ID (For Frontend only):</label>
      <input type="file" id="photoid"><br><br>

      <label for="passport">Passport (For Frontend only):</label>
      <input type="file" id="passport"><br><br>
      
      <label for="visa">Visa (For Frontend only):</label>
      <input type="file" id="visa"><br><br>

      <label for="flightDetails">Flight Details (Take Off & Landing):</label>
      <input type="text" id="flightDetails" name="flightDetails" required><br><br>

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
