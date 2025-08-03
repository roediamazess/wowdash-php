<?php
// Test debug sederhana
echo "<h2>Debug Test</h2>";

// Test 1: Cek apakah file bisa diakses
echo "<h3>1. Testing File Access</h3>";
$apiFile = 'wowdash-php/api-user-simple.php';
if (file_exists($apiFile)) {
    echo "<p style='color: green;'>✅ API file exists</p>";
} else {
    echo "<p style='color: red;'>❌ API file not found</p>";
}

// Test 2: Cek database connection
echo "<h3>2. Testing Database Connection</h3>";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
} else {
    echo "<p style='color: green;'>✅ MySQL connection successful</p>";
    
    // Test database
    $conn->select_db($dbname);
    if ($conn->error) {
        echo "<p style='color: red;'>❌ Database selection failed: " . $conn->error . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Database selection successful</p>";
        
        // Test table
        $result = $conn->query("SHOW TABLES LIKE 'users'");
        if ($result->num_rows > 0) {
            echo "<p style='color: green;'>✅ Users table exists</p>";
        } else {
            echo "<p style='color: red;'>❌ Users table not found</p>";
        }
    }
}

// Test 3: Simulasi API call
echo "<h3>3. Testing API Call</h3>";
$testData = [
    'userName' => 'Test User',
    'userTier' => 'Tier 3',
    'startWork' => '2024-01-01',
    'userRole' => 'User',
    'userEmail' => 'test' . time() . '@example.com',
    'birthday' => '1990-01-01'
];

echo "<p>Test data: " . json_encode($testData) . "</p>";

// Test 4: Cek apakah bisa include file
echo "<h3>4. Testing Include</h3>";
$dbFile = 'wowdash-php/partials/db_connection.php';
if (file_exists($dbFile)) {
    echo "<p style='color: green;'>✅ DB connection file exists</p>";
    
    // Test include
    ob_start();
    try {
        include_once $dbFile;
        echo "<p style='color: green;'>✅ Include successful</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Include failed: " . $e->getMessage() . "</p>";
    }
    ob_end_clean();
} else {
    echo "<p style='color: red;'>❌ DB connection file not found</p>";
}

echo "<h3>✅ Debug test completed!</h3>";
?> 