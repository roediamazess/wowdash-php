<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Database Fix Script</h2>";

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "<p>✅ Database '$dbname' created or already exists</p>";
} else {
    echo "<p>❌ Error creating database: " . $conn->error . "</p>";
}

// Select database
$conn->select_db($dbname);

// Drop existing tables to recreate them
echo "<p>🗑️ Dropping existing tables...</p>";
$conn->query("DROP TABLE IF EXISTS users");
$conn->query("DROP TABLE IF EXISTS tiers");
$conn->query("DROP TABLE IF EXISTS roles");

// Create tiers table
$sql = "CREATE TABLE tiers (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<p>✅ Table 'tiers' created successfully</p>";
} else {
    echo "<p>❌ Error creating tiers table: " . $conn->error . "</p>";
}

// Create roles table
$sql = "CREATE TABLE roles (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<p>✅ Table 'roles' created successfully</p>";
} else {
    echo "<p>❌ Error creating roles table: " . $conn->error . "</p>";
}

// Insert default tiers
$default_tiers = [
    ['name' => 'Tier 1', 'description' => 'Basic tier'],
    ['name' => 'Tier 2', 'description' => 'Standard tier'],
    ['name' => 'Tier 3', 'description' => 'Premium tier'],
    ['name' => 'Premium', 'description' => 'Premium tier'],
    ['name' => 'Standard', 'description' => 'Standard tier'],
    ['name' => 'Basic', 'description' => 'Basic tier']
];

foreach ($default_tiers as $tier) {
    $insert_tier = "INSERT INTO tiers (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_tier);
    $stmt->bind_param("ss", $tier['name'], $tier['description']);
    if ($stmt->execute()) {
        echo "<p>✅ Inserted tier: " . $tier['name'] . "</p>";
    } else {
        echo "<p>❌ Error inserting tier " . $tier['name'] . ": " . $stmt->error . "</p>";
    }
}

// Insert default roles
$default_roles = [
    ['name' => 'Administrator', 'description' => 'Full system access'],
    ['name' => 'Supervisor', 'description' => 'Supervisory access'],
    ['name' => 'Admin Officer', 'description' => 'Admin officer access'],
    ['name' => 'User', 'description' => 'Standard user access'],
    ['name' => 'Client', 'description' => 'Client access']
];

foreach ($default_roles as $role) {
    $insert_role = "INSERT INTO roles (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_role);
    $stmt->bind_param("ss", $role['name'], $role['description']);
    if ($stmt->execute()) {
        echo "<p>✅ Inserted role: " . $role['name'] . "</p>";
    } else {
        echo "<p>❌ Error inserting role " . $role['name'] . ": " . $stmt->error . "</p>";
    }
}

// Create users table with foreign keys
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

// Verify data
echo "<h3>Verification:</h3>";

$result = $conn->query("SELECT COUNT(*) as count FROM tiers");
$tier_count = $result->fetch_assoc()['count'];
echo "<p>Tiers count: $tier_count</p>";

$result = $conn->query("SELECT COUNT(*) as count FROM roles");
$role_count = $result->fetch_assoc()['count'];
echo "<p>Roles count: $role_count</p>";

// Show all tiers
echo "<h3>Tiers:</h3>";
$result = $conn->query("SELECT * FROM tiers ORDER BY name");
while ($row = $result->fetch_assoc()) {
    echo "<p>- " . $row['name'] . " (ID: " . $row['id'] . ")</p>";
}

// Show all roles
echo "<h3>Roles:</h3>";
$result = $conn->query("SELECT * FROM roles ORDER BY name");
while ($row = $result->fetch_assoc()) {
    echo "<p>- " . $row['name'] . " (ID: " . $row['id'] . ")</p>";
}

$conn->close();
echo "<p>✅ Database fix completed!</p>";
?> 