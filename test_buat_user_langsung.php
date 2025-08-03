<?php
// Test buat user langsung
echo "<h2>Test Buat User Langsung</h2>";

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
    exit;
}

echo "<p style='color: green;'>✅ MySQL connection successful</p>";

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

// Select database
$conn->select_db($dbname);

// Create users table if not exists
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
    is_active BOOLEAN DEFAULT TRUE,
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$conn->query($sql);
echo "<p style='color: green;'>✅ Database and table ready</p>";

// Test data
$test_username = 'test_user_' . time();
$test_email = 'test' . time() . '@example.com';
$test_password = password_hash('test123', PASSWORD_DEFAULT);
$test_first_name = 'Fajar';
$test_last_name = 'Ahmad Akbar';
$test_user_tier = 'Tier 3';
$test_user_role = 'User';
$test_start_work = '2024-01-01';
$test_birthday = '1990-01-01';

echo "<p>Test data:</p>";
echo "<ul>";
echo "<li>Username: $test_username</li>";
echo "<li>Email: $test_email</li>";
echo "<li>First Name: $test_first_name</li>";
echo "<li>Last Name: $test_last_name</li>";
echo "<li>Tier: $test_user_tier</li>";
echo "<li>Role: $test_user_role</li>";
echo "<li>Start Work: $test_start_work</li>";
echo "<li>Birthday: $test_birthday</li>";
echo "</ul>";

// Insert user
$sql = "INSERT INTO users (username, email, password, first_name, last_name, user_tier, user_role, start_work, birthday, is_active, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<p style='color: red;'>❌ Prepare failed: " . $conn->error . "</p>";
    exit;
}

echo "<p style='color: green;'>✅ Prepare statement successful</p>";

$stmt->bind_param("sssssssss", 
    $test_username,
    $test_email,
    $test_password,
    $test_first_name,
    $test_last_name,
    $test_user_tier,
    $test_user_role,
    $test_start_work,
    $test_birthday
);

echo "<p style='color: green;'>✅ Bind parameters successful</p>";

if ($stmt->execute()) {
    $user_id = $conn->insert_id;
    echo "<p style='color: green;'>✅ User created successfully! User ID: $user_id</p>";
    
    // Get created user
    $get_user_sql = "SELECT id, CONCAT(first_name, ' ', last_name) as user_name, user_tier, start_work, user_role, email as user_email, birthday FROM users WHERE id = ?";
    $get_user_stmt = $conn->prepare($get_user_sql);
    $get_user_stmt->bind_param("i", $user_id);
    $get_user_stmt->execute();
    $user_result = $get_user_stmt->get_result();
    $user_data = $user_result->fetch_assoc();
    
    echo "<h3>✅ User Details:</h3>";
    echo "<ul>";
    echo "<li>ID: " . $user_data['id'] . "</li>";
    echo "<li>Name: " . $user_data['user_name'] . "</li>";
    echo "<li>Email: " . $user_data['user_email'] . "</li>";
    echo "<li>Tier: " . $user_data['user_tier'] . "</li>";
    echo "<li>Role: " . $user_data['user_role'] . "</li>";
    echo "<li>Start Work: " . $user_data['start_work'] . "</li>";
    echo "<li>Birthday: " . $user_data['birthday'] . "</li>";
    echo "</ul>";
    
    // Clean up - delete test user
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $user_id);
    $delete_stmt->execute();
    echo "<p style='color: blue;'>🧹 Test user cleaned up</p>";
    
} else {
    echo "<p style='color: red;'>❌ Failed to create user: " . $stmt->error . "</p>";
}

$conn->close();
echo "<h3>✅ Test completed!</h3>";
?> 