// Dynamically load the navbar from navigationbar.html
fetch('navigationbar.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('navbar-placeholder').innerHTML = data;

        // Add event listeners for the navbar buttons
        const contactBtn = document.getElementById('contactBtn');
        const developersBtn = document.getElementById('developersBtn');
        const contactPopup = document.getElementById('contactPopup');
        const developersPopup = document.getElementById('developersPopup');
        const closeContact = document.getElementById('closeContact');
        const closeDevelopers = document.getElementById('closeDevelopers');

        // Show Contact Popup
        contactBtn.addEventListener('click', () => {
            contactPopup.style.display = 'block';
        });
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

        // Show Developers Popup
        developersBtn.addEventListener('click', () => {
            developersPopup.style.display = 'block';
        });

        // Close Contact Popup
        closeContact.addEventListener('click', () => {
            contactPopup.style.display = 'none';
        });

        // Close Developers Popup
        closeDevelopers.addEventListener('click', () => {
            developersPopup.style.display = 'none';
        });

        // Close popups by clicking outside them
        window.addEventListener('click', (event) => {
            if (event.target === contactPopup) {
                contactPopup.style.display = 'none';
            }
            if (event.target === developersPopup) {
                developersPopup.style.display = 'none';
            }
        });
    })
    .catch(error => console.error('Error loading navbar:', error));
