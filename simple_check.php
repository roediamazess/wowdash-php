<?php
// Simple script to check database connection and tiers table

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "db_ultimate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to database: " . $dbname . "\n";

// Check if tiers table exists
$sql = "SHOW TABLES LIKE 'tiers'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Table 'tiers' exists.\n";
    
    // Check data in tiers table
    $sql = "SELECT COUNT(*) as count FROM tiers";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo "Number of records in 'tiers' table: " . $row['count'] . "\n";
} else {
    echo "Table 'tiers' does not exist.\n";
}

$conn->close();
?>
