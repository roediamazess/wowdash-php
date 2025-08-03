<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

echo "<h2>Reset Database - New Tier Structure</h2>";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);
echo "<p>✅ Database '$dbname' ready</p>";

// Select database
$conn->select_db($dbname);

// Drop all existing tables
echo "<p>🗑️ Dropping all existing tables...</p>";
$conn->query("DROP TABLE IF EXISTS users");
$conn->query("DROP TABLE IF EXISTS tiers");
$conn->query("DROP TABLE IF EXISTS roles");

// Create tiers table with new structure
echo "<p>📝 Creating new tiers table...</p>";
$sql = "CREATE TABLE tiers (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<p>✅ Table 'tiers' created successfully</p>";
    
    // Insert new tier data
    $new_tiers = [
        ['name' => 'New Born', 'description' => 'New Born tier'],
        ['name' => 'Tier 1', 'description' => 'Tier 1 level'],
        ['name' => 'Tier 2', 'description' => 'Tier 2 level'],
        ['name' => 'Tier 3', 'description' => 'Tier 3 level']
    ];
    
    foreach ($new_tiers as $tier) {
        $insert_tier = "INSERT INTO tiers (name, description) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_tier);
        $stmt->bind_param("ss", $tier['name'], $tier['description']);
        if ($stmt->execute()) {
            echo "<p>✅ Inserted tier: " . $tier['name'] . "</p>";
        } else {
            echo "<p>❌ Error inserting tier " . $tier['name'] . ": " . $stmt->error . "</p>";
        }
    }
} else {
    echo "<p>❌ Error creating tiers table: " . $conn->error . "</p>";
}

// Create roles table
echo "<p>📝 Creating roles table...</p>";
$sql = "CREATE TABLE roles (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<p>✅ Table 'roles' created successfully</p>";
    
    // Insert roles data
    $roles = [
        ['name' => 'Administrator', 'description' => 'Full system access'],
        ['name' => 'Supervisor', 'description' => 'Supervisory access'],
        ['name' => 'Admin Officer', 'description' => 'Admin officer access'],
        ['name' => 'User', 'description' => 'Standard user access'],
        ['name' => 'Client', 'description' => 'Client access']
    ];
    
    foreach ($roles as $role) {
        $insert_role = "INSERT INTO roles (name, description) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_role);
        $stmt->bind_param("ss", $role['name'], $role['description']);
        if ($stmt->execute()) {
            echo "<p>✅ Inserted role: " . $role['name'] . "</p>";
        } else {
            echo "<p>❌ Error inserting role " . $role['name'] . ": " . $stmt->error . "</p>";
        }
    }
} else {
    echo "<p>❌ Error creating roles table: " . $conn->error . "</p>";
}

// Create users table with foreign keys
echo "<p>📝 Creating users table...</p>";
$sql = "CREATE TABLE users (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NULL,
    tier_id INT(11) NOT NULL,
    role_id INT(11) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    start_work DATE NULL,
    birthday DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tier_id) REFERENCES tiers(id),
    FOREIGN KEY (role_id) REFERENCES roles(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "<p>✅ Table 'users' created successfully with foreign keys</p>";
} else {
    echo "<p>❌ Error creating users table: " . $conn->error . "</p>";
}

// Show final data
echo "<h3>📋 Final Tiers:</h3>";
$result = $conn->query("SELECT * FROM tiers ORDER BY name");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>- " . $row['name'] . " (ID: " . $row['id'] . ") - " . $row['description'] . "</p>";
    }
} else {
    echo "<p>❌ No tiers found!</p>";
}

echo "<h3>📋 Final Roles:</h3>";
$result = $conn->query("SELECT * FROM roles ORDER BY name");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>- " . $row['name'] . " (ID: " . $row['id'] . ") - " . $row['description'] . "</p>";
    }
} else {
    echo "<p>❌ No roles found!</p>";
}

$conn->close();
echo "<p>✅ Database reset completed!</p>";
echo "<p><a href='test_final_solution.php'>Test sekarang</a></p>";
?> 