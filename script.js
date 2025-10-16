// Function to dynamically load sections into the content area
function loadSection(file) {
    const contentArea = document.getElementById("contentArea");

    fetch(`sections/${file}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Section file not found: ${file}`);
            }
            return response.text();
        })
        .then(data => {
            contentArea.innerHTML = data;
        })
        .catch(error => {
            contentArea.innerHTML = `<p>Error loading section: ${error.message}</p>`;
        });
}

// Function to filter/search records in a table
function searchRecords(searchBarId, tableId) {
    const searchTerm = document.getElementById(searchBarId).value.toLowerCase();
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);

    rows.forEach(row => {
        const rowData = row.textContent.toLowerCase();
        row.style.display = rowData.includes(searchTerm) ? "" : "none";
    });
}

// Function to load the edit form dynamically
function editRecord(id, table) {
    const contentArea = document.getElementById("contentArea");

    // Make a fetch request to load the edit form for the specific record
    fetch(`edit_form.php?id=${id}&table=${table}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Edit form not found for table: ${table}`);
            }
            return response.text();
        })
        .then(data => {
            contentArea.innerHTML = data;
        })
        .catch(error => {
            contentArea.innerHTML = `<p>Error loading edit form: ${error.message}</p>`;
        });
}

// Function to confirm and delete a record
function deleteRecord(id, table) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = `actions.php?delete=${id}&table=${table}`;
    }
}