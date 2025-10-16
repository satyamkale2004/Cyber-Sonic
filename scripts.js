function filterRecords() {
    const searchValue = document.getElementById('searchBar').value.toLowerCase();
    const table = document.getElementById('recordsTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) { // Skip the header row
        const cells = rows[i].getElementsByTagName('td');
        let match = false;

        for (let j = 1; j < cells.length - 1; j++) { // Skip Actions column
            if (cells[j] && cells[j].innerText.toLowerCase().includes(searchValue)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? '' : 'none';
    }
}
