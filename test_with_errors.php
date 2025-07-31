<?php
// Test script with error reporting

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting test with error reporting...\n";

// Test database connection directly
echo "Testing database connection...\n";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Database connection failed: " . $conn->connect_error . "\n";
} else {
    echo "Database connection successful\n";
    
    // Test if tiers table exists
    echo "Checking if tiers table exists...\n";
    $sql = "SHOW TABLES LIKE 'tiers'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "Tiers table exists\n";
        
        // Test querying tiers table
        echo "Querying tiers table...\n";
        $sql = "SELECT tier_code, tier_name FROM tiers ORDER BY tier_code";
        $result = $conn->query($sql);
        
        if ($result === FALSE) {
            echo "Error querying tiers table: " . $conn->error . "\n";
        } else {
            echo "Query successful\n";
            if ($result->num_rows > 0) {
                echo "Data found in tiers table:\n";
                while($row = $result->fetch_assoc()) {
                    echo "- " . $row['tier_code'] . " (" . $row['tier_name'] . ")\n";
                }
            } else {
                echo "No data in tiers table\n";
            }
        }
    } else {
        echo "Tiers table does not exist\n";
    }
}

$conn->close();
echo "Test completed.\n";
?>
