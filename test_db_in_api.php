<?php
// Test database connection yang digunakan di API

echo "<h2>Testing Database Connection in API</h2>";

// Test koneksi database seperti di API
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

// Test database existence
echo "<h3>2. Testing Database Selection</h3>";
$conn->select_db("db_ultimate");
if ($conn->error) {
    echo "<p style='color: red;'>❌ Failed to select database: " . $conn->error . "</p>";
} else {
    echo "<p style='color: green;'>✅ Database selection successful</p>";
}

// Test users table
echo "<h3>3. Testing Users Table</h3>";
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
    
    // Test insert operation
    echo "<h3>4. Testing Insert Operation</h3>";
    
    $testData = [
        'username' => 'test_user_' . time(),
        'email' => 'test' . time() . '@example.com',
        'password' => password_hash('test123', PASSWORD_DEFAULT),
        'first_name' => 'Test',
        'last_name' => 'User',
        'user_tier' => 'Standard',
        'user_role' => 'User',
        'start_work' => '2024-01-01',
        'birthday' => '1990-01-01'
    ];
    
    $sql = "INSERT INTO users (username, email, password, first_name, last_name, user_tier, user_role, start_work, birthday, is_active, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssssssss", 
            $testData['username'],
            $testData['email'],
            $testData['password'],
            $testData['first_name'],
            $testData['last_name'],
            $testData['user_tier'],
            $testData['user_role'],
            $testData['start_work'],
            $testData['birthday']
        );
        
        if ($stmt->execute()) {
            echo "<p style='color: green;'>✅ Insert operation successful</p>";
            echo "<p>Inserted user ID: " . $conn->insert_id . "</p>";
            
            // Clean up - delete test user
            $delete_sql = "DELETE FROM users WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $conn->insert_id);
            $delete_stmt->execute();
            echo "<p>Test user cleaned up</p>";
        } else {
            echo "<p style='color: red;'>❌ Insert operation failed: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Prepare statement failed: " . $conn->error . "</p>";
    }
    
} else {
    echo "<p style='color: red;'>❌ Table 'users' does not exist</p>";
}

$conn->close();
echo "<h3>✅ Database test completed!</h3>";
?> 