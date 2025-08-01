<?php
// Check activity_number constraint
// File: check_activity_number_constraint.php

// Include database connection
require_once './partials/db_connection.php';

echo "=== CHECKING ACTIVITY_NUMBER CONSTRAINT ===\n";

// Check table structure
$result = $conn->query("DESCRIBE detail_activities");
echo "Table structure:\n";
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . " - " . $row['Key'] . " - " . $row['Null'] . " - " . $row['Default'] . "\n";
}

// Check existing activity numbers
$result = $conn->query("SELECT activity_number, COUNT(*) as count FROM detail_activities GROUP BY activity_number HAVING count > 1");
echo "\nDuplicate activity numbers:\n";
while ($row = $result->fetch_assoc()) {
    echo $row['activity_number'] . " - " . $row['count'] . " times\n";
}

// Check recent activity numbers
$result = $conn->query("SELECT id, activity_number, created_at FROM detail_activities ORDER BY created_at DESC LIMIT 10");
echo "\nRecent activity numbers:\n";
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . " - " . $row['activity_number'] . " - " . $row['created_at'] . "\n";
}

echo "\n=== CHECK COMPLETED ===\n";
?> 