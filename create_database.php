<?php
// Create database script

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully\n";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS db_ultimate";
if ($conn->query($sql) === TRUE) {
    echo "Database 'db_ultimate' created successfully or already exists\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

// Select the database
$conn->select_db("db_ultimate");

// Create tiers table
$sql = "CREATE TABLE IF NOT EXISTS tiers (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    tier_code VARCHAR(50) NOT NULL,
    tier_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'tiers' created successfully or already exists\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Check if tiers table is empty and insert default data if needed
$sql = "SELECT COUNT(*) as count FROM tiers";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo "Inserting default tier data...\n";
    // Insert default tier data
    $tiers = array(
        array("tier_code" => "New Born", "tier_name" => "Baru Masuk"),
        array("tier_code" => "Tier 1", "tier_name" => "Baru Assist"),
        array("tier_code" => "Tier 2", "tier_name" => "Trial Leader"),
        array("tier_code" => "Tier 3", "tier_name" => "Leader")
    );
    
    foreach ($tiers as $tier) {
        $stmt = $conn->prepare("INSERT INTO tiers (tier_code, tier_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $tier['tier_code'], $tier['tier_name']);
        
        if ($stmt->execute()) {
            echo "Tier '" . $tier['tier_code'] . "' inserted successfully\n";
        } else {
            echo "Error inserting tier '" . $tier['tier_code'] . "': " . $stmt->error . "\n";
        }
        
        $stmt->close();
    }
} else {
    echo "Tier data already exists. Skipping default data insertion.\n";
}

$conn->close();
echo "Database setup completed.\n";
?>
