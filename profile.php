<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?showLoginModal=1");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1) Fetch user details
$sql = "
    SELECT 
        u.id AS user_id, 
        u.email,
        up.full_name,
        up.phone,
        up.address
    FROM users u
    LEFT JOIN user_profiles up ON u.id = up.user_id
    WHERE u.id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    $conn->close();
    header("Location: logout.php");
    exit();
}

$fullName = $user['full_name'] ?? '';
$phone    = $user['phone'] ?? '';
$address  = $user['address'] ?? '';

// 2) Build a combined orders array
$orders = [];

// Exam Form orders
$examSql = "SELECT id, created_at FROM exam_form_filling WHERE user_id=? ORDER BY created_at DESC";
$examStmt = $conn->prepare($examSql);
$examStmt->bind_param("i", $user_id);
$examStmt->execute();
$examRes = $examStmt->get_result();
while ($row = $examRes->fetch_assoc()) {
    $orders[] = [
        'service' => 'Exam Form',
        'created_at' => $row['created_at']
    ];
}
$examStmt->close();

// ABC ID Creation orders
$abcSql = "SELECT id, created_at FROM abc_id_creation WHERE user_id=? ORDER BY created_at DESC";
$abcStmt = $conn->prepare($abcSql);
$abcStmt->bind_param("i", $user_id);
$abcStmt->execute();
$abcRes = $abcStmt->get_result();
while ($row = $abcRes->fetch_assoc()) {
    $orders[] = [
        'service' => 'ABC ID Creation',
        'created_at' => $row['created_at']
    ];
}
$abcStmt->close();

// Flight Ticket Booking orders
$flightSql = "SELECT id, created_at FROM flight_ticket_booking WHERE user_id=? ORDER BY created_at DESC";
$flightStmt = $conn->prepare($flightSql);
$flightStmt->bind_param("i", $user_id);
$flightStmt->execute();
$flightRes = $flightStmt->get_result();
while ($row = $flightRes->fetch_assoc()) {
    $orders[] = [
        'service' => 'Flight Ticket Booking',
        'created_at' => $row['created_at']
    ];
}
$flightStmt->close();

// Train Ticket Booking orders
$trainSql = "SELECT id, created_at FROM train_ticket_booking WHERE user_id=? ORDER BY created_at DESC";
$trainStmt = $conn->prepare($trainSql);
$trainStmt->bind_param("i", $user_id);
$trainStmt->execute();
$trainRes = $trainStmt->get_result();
while ($row = $trainRes->fetch_assoc()) {
    $orders[] = [
        'service' => 'Train Ticket Booking',
        'created_at' => $row['created_at']
    ];
}
$trainStmt->close();

// Insurance Premium Payment orders
$insuranceSql = "SELECT id, created_at FROM insurance_premium_payment WHERE user_id=? ORDER BY created_at DESC";
$insuranceStmt = $conn->prepare($insuranceSql);
$insuranceStmt->bind_param("i", $user_id);
$insuranceStmt->execute();
$insuranceRes = $insuranceStmt->get_result();
while ($row = $insuranceRes->fetch_assoc()) {
    $orders[] = [
        'service' => 'Insurance Premium Payment',
        'created_at' => $row['created_at']
    ];
}
$insuranceStmt->close();

// Event Ticket Booking orders
$eventSql = "SELECT id, created_at FROM event_ticket_booking WHERE user_id=? ORDER BY created_at DESC";
$eventStmt = $conn->prepare($eventSql);
$eventStmt->bind_param("i", $user_id);
$eventStmt->execute();
$eventRes = $eventStmt->get_result();
while ($row = $eventRes->fetch_assoc()) {
    $orders[] = [
        'service' => 'Event Ticket Booking',
        'created_at' => $row['created_at']
    ];
}
$eventStmt->close();

// Electricity Bill Payment orders
$electricitySql = "SELECT id, created_at FROM electricity_bill_payment WHERE user_id=? ORDER BY created_at DESC";
$electricityStmt = $conn->prepare($electricitySql);
$electricityStmt->bind_param("i", $user_id);
$electricityStmt->execute();
$electricityRes = $electricityStmt->get_result();
while ($row = $electricityRes->fetch_assoc()) {
    $orders[] = [
        'service' => 'Electricity Bill Payment',
        'created_at' => $row['created_at']
    ];
}
$electricityStmt->close();

// Health Insurance Premium orders
$healthSql = "SELECT id, created_at FROM health_insurance_premium WHERE user_id=? ORDER BY created_at DESC";
$healthStmt = $conn->prepare($healthSql);
$healthStmt->bind_param("i", $user_id);
$healthStmt->execute();
$healthRes = $healthStmt->get_result();
while ($row = $healthRes->fetch_assoc()) {
    $orders[] = [
        'service' => 'Health Insurance Premium',
        'created_at' => $row['created_at']
    ];
}
$healthStmt->close();

$conn->close();

// Sort orders by created_at descending (if not already sorted by each query)
usort($orders, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Cyber Sonic</title>
  <link rel="stylesheet" href="profile.css">
  <link rel="stylesheet" href="navigationbar.css">
</head>
<body>
  <!-- Navbar loaded dynamically -->
  <div id="navbar-placeholder"></div>
  
  <!-- Background Blur Overlay (for popups) -->
  <div class="blur-overlay" id="blurOverlay"></div>
  
  <div class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($fullName ?: 'User'); ?>!</h2>
    <div class="dashboard-content">
      <table class="dashboard-table">
        <tr>
          <th>User ID</th>
          <td><input type="text" id="User-ID" value="<?php echo htmlspecialchars($user['user_id']); ?>" disabled></td>
        </tr>
        <tr>
          <th>Name</th>
          <td><input type="text" id="user-name" value="<?php echo htmlspecialchars($fullName); ?>" disabled></td>
        </tr>
        <tr>
          <th>Email</th>
          <td><input type="email" id="user-email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled></td>
        </tr>
        <tr>
          <th>Phone Number</th>
          <td><input type="text" id="user-phone" value="<?php echo htmlspecialchars($phone); ?>" disabled></td>
        </tr>
        <tr>
          <th>Address</th>
          <td><input type="text" id="user-address" value="<?php echo htmlspecialchars($address); ?>" disabled></td>
        </tr>
      </table>
      <div class="btn-group">
        <button class="edit-btn" id="edit-btn" onclick="toggleEdit()">Edit</button>
        <button class="save-btn" id="save-btn" onclick="saveProfile()" style="display: none;">Save</button>
        <button class="delete-btn" id="delete-btn" onclick="deleteProfile()">Delete</button>
      </div>
    </div>
    
    <div class="orders-section">
      <h3>User Orders</h3>
      <table class="orders-table">
        <tr>
          <th>Sr. No.</th>
          <th>Order Name</th>
        </tr>
        <?php
        $srNo = 1;
        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>" . $srNo . "</td>";
            echo "<td>" . htmlspecialchars($order['service']) . "</td>";
            echo "</tr>";
            $srNo++;
        }
        ?>
      </table>
    </div>
    
    <div class="logout-container">
      <button class="logout-btn" id="logout-btn" onclick="window.location.href='logout.php'">
        <i class="logout-icon">🔓</i> Log Out
      </button>
    </div>
  </div>

  <!-- Include profile.js for toggleEdit, saveProfile, deleteProfile functions -->
  <script src="profile.js"></script>
  
  <!-- Load the navbar dynamically -->
  <script>
    fetch('navigationbar.html')
      .then(response => response.text())
      .then(data => {
        document.getElementById('navbar-placeholder').innerHTML = data;
      })
      .catch(error => console.error('Error loading navbar:', error));
    
    function deleteProfile() {
      if (!confirm("Are you sure you want to delete your profile? This action cannot be undone.")) return;
      
      fetch('delete_profile.php', { method: 'POST' })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert("Your profile has been deleted.");
            window.location.href = "index.php?showLoginModal=1";
          } else {
            alert("Error deleting profile: " + data.error);
          }
        })
        .catch(error => {
          console.error(error);
          alert("An error occurred while deleting your profile.");
        });
    }
    
    // toggleEdit() and saveProfile() should be defined in profile.js
  </script>
</body>
</html>
