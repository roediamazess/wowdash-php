<?php
// check_tiers.php - Check if tiers table exists and has data

// Include database connection
include_once './partials/db_connection.php';

echo "Database connection status: " . ($conn->connect_error ? "FAILED - " . $conn->connect_error : "SUCCESS") . "\n";

// Check if tiers table exists
echo "Checking if 'tiers' table exists...\n";
$sql = "SHOW TABLES LIKE 'tiers'";
$result = $conn->query($sql);

if ($result === FALSE) {
    echo "Error executing query: " . $conn->error . "\n";
} else {
    echo "Query executed successfully.\n";
    
    if ($result->num_rows > 0) {
        echo "Table 'tiers' exists.\n";
        
        // Check the structure of the tiers table
        echo "\nTable structure:\n";
        $sql = "DESCRIBE tiers";
        $result = $conn->query($sql);
        
        if ($result === FALSE) {
            echo "Error executing describe query: " . $conn->error . "\n";
        } else {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
                }
            }
            
            // Check data in tiers table
            echo "\nData in tiers table:\n";
            $sql = "SELECT * FROM tiers";
            $result = $conn->query($sql);
            
            if ($result === FALSE) {
                echo "Error executing select query: " . $conn->error . "\n";
            } else {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "- ID: " . $row['id'] . ", Code: " . $row['tier_code'] . ", Name: " . $row['tier_name'] . "\n";
                    }
                } else {
                    echo "No data found in tiers table.\n";
                }
            }
        }
    } else {
        echo "Table 'tiers' does not exist.\n";
        
        // Try to create the table
        echo "\nTrying to create 'tiers' table...\n";
        $sql = "CREATE TABLE IF NOT EXISTS tiers (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            tier_code VARCHAR(50) NOT NULL,
            tier_name VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($sql) === TRUE) {
            echo "Table 'tiers' created successfully.\n";
        } else {
            echo "Error creating table: " . $conn->error . "\n";
        }
    }
}

// Close connection
$conn->close();
echo "Database connection closed.\n";
?>
