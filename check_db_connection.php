<?php
// Check database connection

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

echo "<h2>Database Connection Test</h2>";

// Test connection without database
echo "<h3>1. Testing MySQL Connection</h3>";
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
    exit;
} else {
    echo "<p style='color: green;'>✅ MySQL connection successful</p>";
}

// Test database existence
echo "<h3>2. Testing Database Existence</h3>";
$result = $conn->query("SHOW DATABASES LIKE 'db_ultimate'");
if ($result->num_rows > 0) {
    echo "<p style='color: green;'>✅ Database 'db_ultimate' exists</p>";
} else {
    echo "<p style='color: red;'>❌ Database 'db_ultimate' does not exist</p>";
    echo "<p>Creating database...</p>";
    if ($conn->query("CREATE DATABASE db_ultimate")) {
        echo "<p style='color: green;'>✅ Database 'db_ultimate' created successfully</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create database: " . $conn->error . "</p>";
    }
}

// Test connection with database
echo "<h3>3. Testing Database Connection</h3>";
$conn->select_db("db_ultimate");
if ($conn->error) {
    echo "<p style='color: red;'>❌ Failed to select database: " . $conn->error . "</p>";
} else {
    echo "<p style='color: green;'>✅ Database connection successful</p>";
}

// Test users table
echo "<h3>4. Testing Users Table</h3>";
$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result->num_rows > 0) {
    echo "<p style='color: green;'>✅ Table 'users' exists</p>";
    
    // Check table structure
    $result = $conn->query("DESCRIBE users");
    echo "<h4>Table Structure:</h4>";
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check data count
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    echo "<p>Number of users: " . $row['count'] . "</p>";
    
} else {
    echo "<p style='color: red;'>❌ Table 'users' does not exist</p>";
    echo "<p>Creating users table...</p>";
    
    $sql = "CREATE TABLE users (
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        user_tier VARCHAR(100) DEFAULT 'Standard',
        user_role VARCHAR(100) DEFAULT 'User',
        start_work DATE NULL,
        birthday DATE NULL,
        phone VARCHAR(20) NULL,
        avatar VARCHAR(255) NULL,
        is_active BOOLEAN DEFAULT TRUE,
        is_verified BOOLEAN DEFAULT FALSE,
        email_verified_at TIMESTAMP NULL,
        last_login TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql)) {
        echo "<p style='color: green;'>✅ Table 'users' created successfully</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to create table: " . $conn->error . "</p>";
    }
}

$conn->close();
echo "<h3>✅ Database check completed!</h3>";
?> 