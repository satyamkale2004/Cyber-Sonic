<?php
include 'db_config.php';

$id = $_GET['id'] ?? null;
$table = $_GET['table'] ?? null;

if (!$id || !$table) {
    echo "<p>Invalid request. Missing record ID or table name.</p>";
    exit;
}

// Fetch the record from the specified table
$sql = "SELECT * FROM $table WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $record = $result->fetch_assoc();
} else {
    echo "<p>Record not found.</p>";
    exit;
}
?>

<div class="section">
    <h2>Edit Record in <?php echo ucfirst($table); ?></h2>
    
    <form method="POST" action="actions.php">
        <?php foreach ($record as $field => $value): ?>
            <?php if ($field === 'id'): ?>
                <input type="hidden" name="<?php echo $field; ?>" value="<?php echo $value; ?>">
            <?php else: ?>
                <label for="<?php echo $field; ?>"><?php echo ucfirst(str_replace('_', ' ', $field)); ?></label>
                <input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $value; ?>" required>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit" name="updateRecord" value="<?php echo $table; ?>">Update Record</button>
    </form>
</div>