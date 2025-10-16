<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cyber Sonic - Home</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="navigationbar.css">
  <style>
    /* Blur Effect for background when popup is open */
    .blur {
      filter: blur(5px);
      pointer-events: none;
    }
    /* Modal Overlay using Flexbox for Centering */
    .modal-overlay {
      display: none; /* hidden by default */
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.6);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      width: 400px;
      max-width: 90%;
      position: relative;
    }
    .close-btn {
      position: absolute;
      right: 20px;
      top: 10px;
      font-size: 24px;
      cursor: pointer;
    }
    /* Panels for login and register */
    #loginPanel, #registerPanel {
      display: none; /* toggled by JS */
    }
    #loginPanel h2, #registerPanel h2 {
      text-align: center;
      margin-top: 0;
    }
    form {
      margin-top: 20px;
    }
    form label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }
    form input {
      width: 100%;
      padding: 8px;
      margin-bottom: 12px;
      box-sizing: border-box;
    }
    form button {
      width: 100%;
      padding: 10px;
      background: #3498db;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    form button:hover {
      background: #2980b9;
    }
    .switch-link {
      color: #3498db;
      text-decoration: underline;
      cursor: pointer;
    }
    .switch-link:hover {
      text-decoration: none;
    }
    /* Basic styling for main content */
    .main-content {
      padding: 20px;
      text-align: center;
    }
    .join-now-btn {
      background: #3498db;
      color: #fff;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 4px;
    }
    .join-now-btn:hover {
      background: #2980b9;
    }
  </style>
</head>
<body>
  <!-- Navbar placeholder (will be loaded dynamically) -->
  <div id="navbar-placeholder"></div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="welcome-section">
      <div class="welcome-text">Welcome to</div>
      <div class="cyber-sonic">CYBER SONIC</div>
      <div class="solution-text">"Your ultimate solution to all the cyber services"</div>
      <?php if (!$loggedIn): ?>
        <button id="joinNowBtn" class="join-now-btn">Let's Join Now !!</button>
      <?php endif; ?>
    </div>
    
    <!-- Additional Sections -->
    <div class="container">
      <div class="Our-services">
        <h2>Our Services</h2>
        <p>Exams form filling, ABC ID creation, Flight ticket booking, Train ticket booking, Insurance Premium Payment, Event Ticket Booking, Electricity Bill Payment, Health Insurance Premium Renewal.</p>
      </div>
      <div class="about-us">
        <h2>About Us</h2>
        <p>At Cyber Sonic, we provide seamless and reliable services in a variety of areas. Our mission is to make your life easier by offering convenient and trustworthy solutions for your everyday needs.</p>
      </div>
    </div>

    <!-- Terms and condition -->
    <div class="terms-conditions">
      <h2>Terms and Conditions</h2>&nbsp;
      <p>By using Cyber Sonic, you agree to provide accurate and complete information while availing our services. It is the user's responsibility to ensure that all details, including personal information and form submissions, are correct and up to date. Cyber Sonic takes full responsibility for correctly processing and submitting the forms on your behalf. However, we are not liable for any discrepancies caused by incorrect details provided by the user. Our services aim to provide a seamless and error-free experience, ensuring accuracy and compliance in every transaction. By proceeding, you acknowledge and accept these terms.</p>
    </div>

    <!-- Steps for accessing service -->
    <div class="accessing-service">
      <h2>Steps for accessing service</h2>&nbsp;
      <p>
        1. Click on Let's join<br>
        2. If you are a new user, then register first<br>
        3. After completing registration, do login<br>
        4. Enter correct credentials during login process<br>
        5. After successfully logging in<br>
        6. Click on Service button<br>
        7. You will be redirected to the Service page<br>
        8. Select the particular Service<br>
        9. Upload required docs<br>
        10. And there you go<br>
        11. You have successfully accessed the service.
      </p>
    </div>
  </div>
    
  <!-- Join Now Modal (Floating Login/Register Popup) -->
  <div id="joinModal" class="modal-overlay">
    <div class="modal-content">
      <span class="close-btn" id="closeJoinModal">&times;</span>
      <!-- Login Panel -->
      <div id="loginPanel">
        <h2>Login</h2>
        <form method="POST" action="login.php">
          <label for="loginEmail">Email:</label>
          <input type="email" id="loginEmail" name="email" required>
          <label for="loginPassword">Password:</label>
          <input type="password" id="loginPassword" name="password" required>
          <button type="submit">Login</button>
        </form>
        <p>New user? <span class="switch-link" id="showRegister">Register here</span></p>
      </div>
      <!-- Register Panel -->
      <div id="registerPanel">
        <h2>Register</h2>
        <form method="POST" action="register.php">
          <label for="regEmail">Email:</label>
          <input type="email" id="regEmail" name="email" required>
          <label for="regPassword">Password:</label>
          <input type="password" id="regPassword" name="regPassword" required>
          <button type="submit">Register</button>
        </form>
        <p>Already have an account? <span class="switch-link" id="showLogin">Login here</span></p>
      </div>
    </div>
  </div>

  <!-- (Other popups like Contact Us and Developers remain unchanged) -->

  <script>
    // Global variable for login status from PHP session
    var loggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
    
    // Load the navbar dynamically
    fetch('navigationbar.html')
      .then(response => response.text())
      .then(data => {
        document.getElementById('navbar-placeholder').innerHTML = data;
      })
      .catch(error => console.error('Error loading navbar:', error));

    // Modal functions and variables
    const joinModal = document.getElementById('joinModal');
    const joinNowBtn = document.getElementById('joinNowBtn'); // may be null if logged in
    const closeJoinModal = document.getElementById('closeJoinModal');
    const mainContent = document.querySelector('.main-content');
    const loginPanel = document.getElementById('loginPanel');
    const registerPanel = document.getElementById('registerPanel');
    const showRegister = document.getElementById('showRegister');
    const showLogin = document.getElementById('showLogin');

    function openJoinModal() {
      // Show login panel by default
      loginPanel.style.display = 'block';
      registerPanel.style.display = 'none';
      joinModal.style.display = 'flex';
      mainContent.classList.add('blur');
    }

    function closeJoinModalFunc() {
      joinModal.style.display = 'none';
      mainContent.classList.remove('blur');
    }

    if (joinNowBtn) {
      joinNowBtn.addEventListener('click', openJoinModal);
    }
    closeJoinModal.addEventListener('click', closeJoinModalFunc);
    window.addEventListener('click', (e) => {
      if (e.target === joinModal) {
        closeJoinModalFunc();
      }
    });

    // Toggle between Login and Register panels
    showRegister.addEventListener('click', (event) => {
      event.preventDefault();
      loginPanel.style.display = 'none';
      registerPanel.style.display = 'block';
    });
    showLogin.addEventListener('click', (event) => {
      event.preventDefault();
      registerPanel.style.display = 'none';
      loginPanel.style.display = 'block';
    });

    // Auto-open modal if URL contains ?showLoginModal=1
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('showLoginModal') === '1') {
      openJoinModal();
    }
  </script>
</body>
</html>
