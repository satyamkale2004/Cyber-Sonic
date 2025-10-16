<?php
include 'db_config.php';

// Update Record Logic
if (isset($_POST['updateRecord'])) {
    $table = $_POST['updateRecord'];
    $id = $_POST['id'];
    unset($_POST['updateRecord'], $_POST['id']);

    $updates = [];
    foreach ($_POST as $field => $value) {
        $updates[] = "$field = '$value'";
    }

    $sql = "UPDATE $table SET " . implode(', ', $updates) . " WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>