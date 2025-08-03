<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

echo "<h2>Database Check & Fix</h2>";

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

// Check if tiers table exists
$result = $conn->query("SHOW TABLES LIKE 'tiers'");
if ($result->num_rows == 0) {
    echo "<p>❌ Table 'tiers' does not exist. Creating...</p>";
    
    // Drop if exists and recreate
    $conn->query("DROP TABLE IF EXISTS tiers");
    
    $sql = "CREATE TABLE tiers (
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL UNIQUE,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>✅ Table 'tiers' created successfully</p>";
        
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
    } else {
        echo "<p>❌ Error creating tiers table: " . $conn->error . "</p>";
    }
} else {
    echo "<p>✅ Table 'tiers' exists</p>";
    
    // Check if tiers table has data
    $result = $conn->query("SELECT COUNT(*) as count FROM tiers");
    $tier_count = $result->fetch_assoc()['count'];
    echo "<p>📊 Tiers count: $tier_count</p>";
    
    if ($tier_count == 0) {
        echo "<p>⚠️ Table 'tiers' is empty. Inserting default data...</p>";
        
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
    }
}

// Check if roles table exists
$result = $conn->query("SHOW TABLES LIKE 'roles'");
if ($result->num_rows == 0) {
    echo "<p>❌ Table 'roles' does not exist. Creating...</p>";
    
    // Drop if exists and recreate
    $conn->query("DROP TABLE IF EXISTS roles");
    
    $sql = "CREATE TABLE roles (
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL UNIQUE,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>✅ Table 'roles' created successfully</p>";
        
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
    } else {
        echo "<p>❌ Error creating roles table: " . $conn->error . "</p>";
    }
} else {
    echo "<p>✅ Table 'roles' exists</p>";
    
    // Check if roles table has data
    $result = $conn->query("SELECT COUNT(*) as count FROM roles");
    $role_count = $result->fetch_assoc()['count'];
    echo "<p>📊 Roles count: $role_count</p>";
    
    if ($role_count == 0) {
        echo "<p>⚠️ Table 'roles' is empty. Inserting default data...</p>";
        
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
    }
}

// Show all tiers
echo "<h3>📋 Current Tiers:</h3>";
$result = $conn->query("SELECT * FROM tiers ORDER BY name");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>- " . $row['name'] . " (ID: " . $row['id'] . ") - " . $row['description'] . "</p>";
    }
} else {
    echo "<p>❌ No tiers found!</p>";
}

// Show all roles
echo "<h3>📋 Current Roles:</h3>";
$result = $conn->query("SELECT * FROM roles ORDER BY name");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>- " . $row['name'] . " (ID: " . $row['id'] . ") - " . $row['description'] . "</p>";
    }
} else {
    echo "<p>❌ No roles found!</p>";
}

$conn->close();
echo "<p>✅ Database check completed!</p>";
echo "<p><a href='test_api_simple.php'>Test API sekarang</a></p>";
?> 