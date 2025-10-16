<?php
$conn = new mysqli("localhost", "root", "Hrushi@2005", "cyber_sonic");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM records");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['mobile']}</td>
            <td>{$row['email']}</td>
            <td>{$row['service']}</td>
            <td>{$row['date']}</td>
            <td>{$row['time']}</td>
            <td>
                <form method='GET' action='edit.php' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button type='submit'>Edit</button>
                </form>
                <form method='POST' action='delete.php' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button type='submit'>Delete</button>
                </form>
            </td>
          </tr>";
}
?>
