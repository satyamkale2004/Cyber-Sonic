<?php
$conn = new mysqli("localhost", "root", "Hrushi@2005", "cyber_sonic");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM records WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Record</title>
</head>
<body>
    <div class="header">
        <h1>Edit Record</h1>
    </div>
    <div class="form">
        <form method="POST" action="update.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
            <input type="text" name="mobile" value="<?php echo $row['mobile']; ?>" required>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
            <input type="text" name="service" value="<?php echo $row['service']; ?>" required>
            <input type="date" name="date" value="<?php echo $row['date']; ?>" required>
            <input type="time" name="time" value="<?php echo $row['time']; ?>" required>
            <button type="submit">Update Record</button>
        </form>
    </div>
</body>
</html>
