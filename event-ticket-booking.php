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
    $eventName         = trim($_POST['eventname']);
    $emailConfirmation = trim($_POST['emailConfirmation']);
    $eventDate         = $_POST['event_date'];
    $eventTime         = $_POST['event_time'];

    $stmt = $conn->prepare("
        INSERT INTO event_ticket_booking (
            user_id,
            full_name,
            event_name,
            email_confirmation,
            event_date,
            event_time
        ) VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssss", $user_id, $fullName, $eventName, $emailConfirmation, $eventDate, $eventTime);

    if ($stmt->execute()) {
        $message = "Event ticket booked successfully!";
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
  <title>Event Ticket Booking - Cyber Sonic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="event.css">
</head>
<body>
  <h1>Event Ticket Booking</h1>
  <p>Welcome to our Event Ticket Booking service. Please fill in the details below to book your event ticket.</p>
  
  <?php if ($message): ?>
    <p style="color:green; font-weight:bold;"><?php echo $message; ?></p>
  <?php endif; ?>

  <!-- For file input (idProof), we remove the name attribute -->
  <form method="POST" action="event-ticket-booking.php" enctype="multipart/form-data">
      <label for="fullName">Full Name:</label>
      <input type="text" id="fullName" name="fullName" required><br><br>
    
      <label for="idProof">Valid ID Proof (For Frontend Only):</label><br>
      <input type="file" id="idProof"><br><br>
        
      <label for="eventname">Name Of Event:</label>
      <input type="text" id="eventname" name="eventname" required><br>
        
      <label for="emailConfirmation">Email-ID:</label>
      <input type="email" id="emailConfirmation" name="emailConfirmation" required><br>
      
      <label for="event_date">Event Date:</label>
      <input type="date" id="event_date" name="event_date" required><br><br>
      
      <label for="event_time">Event Time:</label>
      <input type="time" id="event_time" name="event_time" required><br><br>
      
      <button type="submit">Submit</button>
  </form>
  <footer>
      &copy; 2025 Cyber Sonic. All rights reserved. | <a href="index.php">Home</a>
  </footer>
</body>
</html>
