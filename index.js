// Show the Contact Us Popup just below the Contact button
document.getElementById('contactBtn').addEventListener('click', function() {
    const contactPopup = document.getElementById('contactPopup');
    contactPopup.style.display = 'block';
});

document.getElementById('closeContact').addEventListener('click', function() {
    const contactPopup = document.getElementById('contactPopup');
    contactPopup.style.display = 'none';
});

// Enable the Developers section
document.getElementById('developersBtn').addEventListener('click', function() {
    const developersPopup = document.getElementById('developersPopup');
    developersPopup.style.display = 'block';
});

document.getElementById('closeDevelopers').addEventListener('click', function() {
    const developersPopup = document.getElementById('developersPopup');
    developersPopup.style.display = 'none';
});

// Optionally add an action for the Profile Icon (this can be customized)
document.getElementById('profileBtn').addEventListener('click', function() {
    alert("Profile icon clicked");
});