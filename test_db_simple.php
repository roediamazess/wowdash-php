<?php
echo "<h2>Test Database Simple</h2>";

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

echo "<h3>1. Testing MySQL Connection</h3>";
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
    exit;
} else {
    echo "<p style='color: green;'>✅ MySQL connection successful</p>";
}

// Create database if not exists
echo "<h3>2. Creating Database</h3>";
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✅ Database created or already exists</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating database: " . $conn->error . "</p>";
    exit;
}

// Select database
$conn->select_db($dbname);

// Create users table if not exists
echo "<h3>3. Creating Users Table</h3>";
$sql = "CREATE TABLE IF NOT EXISTS users (
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

if ($conn->query($sql) === TRUE) {
    echo "<p style='color: green;'>✅ Table created or already exists</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating table: " . $conn->error . "</p>";
    exit;
}

// Test insert
echo "<h3>4. Testing Insert</h3>";
$test_username = 'test_user_' . time();
$test_email = 'test' . time() . '@example.com';
$test_password = password_hash('test123', PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password, first_name, last_name, user_tier, user_role, start_work, birthday, is_active, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssssssss", 
        $test_username,
        $test_email,
        $test_password,
        'Test',
        'User',
        'Tier 3',
        'User',
        '2024-01-01',
        '1990-01-01'
    );
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Insert successful! User ID: " . $conn->insert_id . "</p>";
        
        // Clean up
        $delete_sql = "DELETE FROM users WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $conn->insert_id);
        $delete_stmt->execute();
        echo "<p>Test user cleaned up</p>";
    } else {
        echo "<p style='color: red;'>❌ Insert failed: " . $stmt->error . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Prepare failed: " . $conn->error . "</p>";
}

$conn->close();
echo "<h3>✅ Database test completed!</h3>";
?> 