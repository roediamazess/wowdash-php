<?php
// Check if table exists
// File: check_table_exists.php

require_once './partials/db_connection.php';

echo "Checking if detail_activities table exists...\n";

$result = $conn->query("SHOW TABLES LIKE 'detail_activities'");
if ($result->num_rows > 0) {
    echo "✅ Table 'detail_activities' exists\n";
    
    // Check structure
    $structure = $conn->query("DESCRIBE detail_activities");
    echo "Table structure:\n";
    while ($row = $structure->fetch_assoc()) {
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} else {
    echo "❌ Table 'detail_activities' does not exist\n";
}

echo "\nChecking if applications table exists...\n";
$result = $conn->query("SHOW TABLES LIKE 'applications'");
if ($result->num_rows > 0) {
    echo "✅ Table 'applications' exists\n";
} else {
    echo "❌ Table 'applications' does not exist\n";
}

echo "\nDatabase connection test: ";
if ($conn->ping()) {
    echo "✅ Working\n";
} else {
    echo "❌ Failed\n";
}
?> 