// profile.js

function toggleEdit() {
    // Enable all the fields except user ID and email if you want
    document.getElementById('user-name').disabled = false;
    document.getElementById('user-phone').disabled = false;
    document.getElementById('user-address').disabled = false;

    // Hide Edit button, show Save button
    document.getElementById('edit-btn').style.display = 'none';
    document.getElementById('save-btn').style.display = 'inline-block';
}

function saveProfile() {
    const fullName = document.getElementById('user-name').value;
    const phone = document.getElementById('user-phone').value;
    const address = document.getElementById('user-address').value;

    fetch('update_profile.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ full_name: fullName, phone: phone, address: address })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Profile updated successfully!");

            // Disable fields again
            document.getElementById('user-name').disabled = true;
            document.getElementById('user-phone').disabled = true;
            document.getElementById('user-address').disabled = true;

            // Show Edit button, hide Save button
            document.getElementById('edit-btn').style.display = 'inline-block';
            document.getElementById('save-btn').style.display = 'none';
        } else {
            alert("Error updating profile: " + data.error);
        }
    })
    .catch(error => {
        console.error(error);
        alert("An error occurred while updating profile.");
    });
}

function deleteProfile() {
    if (!confirm("Are you sure you want to delete your profile and all your data?")) {
        return;
    }

    fetch('delete_profile.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Your profile and all data have been deleted.");
            window.location.href = 'login.php'; // or index.php, etc.
        } else {
            alert("Error deleting profile: " + data.error);
        }
    })
    .catch(error => {
        console.error(error);
        alert("An error occurred while deleting your profile.");
    });
}

function logout() {
    window.location.href = 'logout.php';
}
