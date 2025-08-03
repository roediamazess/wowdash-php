<?php
// Test debug mendalam
echo "<h2>Debug Test Mendalam</h2>";

// Test 1: Cek apakah file bisa diakses
echo "<h3>1. Testing File Access</h3>";
$apiFile = 'wowdash-php/api-user-final.php';
if (file_exists($apiFile)) {
    echo "<p style='color: green;'>✅ API file exists</p>";
    
    // Cek isi file
    $content = file_get_contents($apiFile);
    if (strpos($content, '<?php') !== false) {
        echo "<p style='color: green;'>✅ File contains PHP code</p>";
    } else {
        echo "<p style='color: red;'>❌ File does not contain PHP code</p>";
    }
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
            
            // Test table structure
            $result = $conn->query("DESCRIBE users");
            echo "<p>Table structure:</p>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['Field']} - {$row['Type']} - {$row['Null']} - {$row['Key']} - {$row['Default']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p style='color: red;'>❌ Users table not found</p>";
        }
    }
}

// Test 3: Simulasi API call langsung
echo "<h3>3. Testing Direct API Call</h3>";
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

// Test 5: Test API langsung dengan cURL
echo "<h3>5. Testing API with cURL</h3>";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Ultimate-Dashboard/wowdash-php/api-user-final.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "<p style='color: red;'>❌ cURL Error: $error</p>";
} else {
    echo "<p style='color: green;'>✅ cURL request successful</p>";
    echo "<p>HTTP Code: $httpCode</p>";
    echo "<p>Response: $response</p>";
}

// Test 6: Test database insert langsung
echo "<h3>6. Testing Direct Database Insert</h3>";
try {
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
            echo "<p style='color: green;'>✅ Direct insert successful! User ID: " . $conn->insert_id . "</p>";
            
            // Clean up
            $delete_sql = "DELETE FROM users WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $conn->insert_id);
            $delete_stmt->execute();
            echo "<p>Test user cleaned up</p>";
        } else {
            echo "<p style='color: red;'>❌ Direct insert failed: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Prepare failed: " . $conn->error . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Exception: " . $e->getMessage() . "</p>";
}

$conn->close();
echo "<h3>✅ Debug test mendalam completed!</h3>";
?> 