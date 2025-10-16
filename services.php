<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?showLoginModal=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Services - Cyber Sonic</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="services.css">
  <link rel="stylesheet" href="navigationbar.css">
</head>
<body>
  <!-- Navbar loaded dynamically -->
  <div id="navbar-placeholder"></div>
  
  <!-- Background Blur Overlay -->
  <div class="blur-overlay" id="blurOverlay"></div>
  
  <!-- Contact Us Popup -->
  <div class="popup" id="contactPopup">
    <div class="popup-content">
      <span class="close-btn" id="closeContact">&times;</span>
      <h2>Contact Us</h2>
      <p>Email: harshadnirgude11@gmail.com</p>
      <p>Phone: +91-8010787154</p>
    </div>
  </div>
  
  <!-- Developers Popup -->
  <div class="popup" id="developersPopup">
    <div class="popup-content">
      <span class="close-btn" id="closeDevelopers">&times;</span>
      <h2>Developers</h2>
      <div class="developer-info">
        <div class="developer">
          <img src="images/developer1.jpg" alt="Developer 1">
          <p>Name: Satyam Kale</p>
          <p>Email: satyamkale02@gmail.com</p>
          <p><a href="#">LinkedIn</a></p>
        </div>
        <div class="developer">
          <img src="images/developer2.jpg" alt="Developer 2">
          <p>Name: Hrushikesh Ugale</p>
          <p>Email: rushikesh.k.ugale@gmail.com</p>
          <p><a href="#">LinkedIn</a></p>
        </div>
        <div class="developer">
          <img src="images/developer3.jpg" alt="Developer 3">
          <p>Name: Harshvardhan Nirgude</p>
          <p>Email: harshadnirgude11@gmail.com</p>
          <p><a href="#">LinkedIn</a></p>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Page Title -->
  <h1>OUR SERVICES</h1>
  
  <!-- Services Grid -->
  <div class="services-container">
    <div class="service-box" onclick="location.href='exam-form-filling.php'">
      <h3>Exam Form Filling</h3>
      <p>Hassle-free exam form filling services.</p>
    </div>
    <div class="service-box" onclick="location.href='abc-id-creation.php'">
      <h3>ABC ID Creation</h3>
      <p>Get your unique ABC ID created seamlessly.</p>
    </div>
    <div class="service-box" onclick="location.href='flight-ticket-booking.php'">
      <h3>Flight Ticket Booking</h3>
      <p>Book flight tickets with ease and convenience.</p>
    </div>
    <div class="service-box" onclick="location.href='train-ticket-booking.php'">
      <h3>Train Ticket Booking</h3>
      <p>Reserve your train tickets quickly and securely.</p>
    </div>
    <div class="service-box" onclick="location.href='insurance-premium-payment.php'">
      <h3>Insurance Premium Payment</h3>
      <p>Pay your insurance premiums effortlessly.</p>
    </div>
    <div class="service-box" onclick="location.href='event-ticket-booking.php'">
      <h3>Event Ticket Booking</h3>
      <p>Book tickets for your favorite events easily.</p>
    </div>
    <div class="service-box" onclick="location.href='electricity-bill-payment.php'">
      <h3>Electricity Bill Payment</h3>
      <p>Pay your electricity bills conveniently.</p>
    </div>
    <div class="service-box" onclick="location.href='health-insurance-premium.php'">
      <h3>Health Insurance Premium</h3>
      <p>Renew your health insurance premiums effortlessly.</p>
    </div>
  </div>
  
  <script>
    // Load navbar dynamically for services page
    fetch('navigationbar.html')
      .then(response => response.text())
      .then(data => {
        document.getElementById('navbar-placeholder').innerHTML = data;
        
        // Setup Contact Us and Developers popups (unchanged)
        const contactBtn = document.getElementById('contactBtn');
        const developersBtn = document.getElementById('developersBtn');
        const contactPopup = document.getElementById('contactPopup');
        const developersPopup = document.getElementById('developersPopup');
        const closeContact = document.getElementById('closeContact');
        const closeDevelopers = document.getElementById('closeDevelopers');
        const blurOverlay = document.getElementById('blurOverlay');
        
        function showPopup(popup) {
          popup.style.display = 'block';
          blurOverlay.style.display = 'block';
        }
        
        function closePopup(popup) {
          popup.style.display = 'none';
          blurOverlay.style.display = 'none';
        }
        
        contactBtn.addEventListener('click', () => showPopup(contactPopup));
        developersBtn.addEventListener('click', () => showPopup(developersPopup));
        closeContact.addEventListener('click', () => closePopup(contactPopup));
        closeDevelopers.addEventListener('click', () => closePopup(developersPopup));
        
        window.addEventListener('click', (event) => {
          if (event.target === contactPopup || event.target === developersPopup) {
            closePopup(event.target);
          }
        });
      })
      .catch(error => console.error('Error loading navbar:', error));
  </script>
</body>
</html>
