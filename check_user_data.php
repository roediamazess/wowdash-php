<?php
// Check user data script
include_once __DIR__ . '/partials/db_connection.php';

echo "=== Checking User Data ===\n";

// Check table structure
$sql = "DESCRIBE users";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    echo "Table structure:\n";
    while ($row = $result->fetch_assoc()) {
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
}

echo "\n=== User Data ===\n";
$sql = "SELECT user_id, user_name FROM users LIMIT 5";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "User ID: '" . $row['user_id'] . "' (Type: " . gettype($row['user_id']) . "), Name: " . $row['user_name'] . "\n";
    }
} else {
    echo "No users found\n";
}

echo "\n=== Total Users ===\n";
$sql = "SELECT COUNT(*) as total FROM users";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    echo "Total users: " . $row['total'] . "\n";
}
?> 