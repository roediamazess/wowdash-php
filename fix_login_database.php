<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

echo "<h2>Fix Login Database Structure</h2>";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select database
$conn->select_db($dbname);

// Check if users table exists
$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result->num_rows > 0) {
    echo "<p>✅ Table 'users' exists</p>";
    
    // Check if is_active column exists
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'is_active'");
    if ($result->num_rows == 0) {
        echo "<p>📝 Adding is_active column...</p>";
        $conn->query("ALTER TABLE users ADD COLUMN is_active TINYINT(1) DEFAULT 1");
        echo "<p>✅ is_active column added</p>";
    } else {
        echo "<p>✅ is_active column exists</p>";
    }
    
    // Check if is_verified column exists
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'is_verified'");
    if ($result->num_rows == 0) {
        echo "<p>📝 Adding is_verified column...</p>";
        $conn->query("ALTER TABLE users ADD COLUMN is_verified TINYINT(1) DEFAULT 1");
        echo "<p>✅ is_verified column added</p>";
    } else {
        echo "<p>✅ is_verified column exists</p>";
    }
    
    // Check if last_login column exists
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'last_login'");
    if ($result->num_rows == 0) {
        echo "<p>📝 Adding last_login column...</p>";
        $conn->query("ALTER TABLE users ADD COLUMN last_login TIMESTAMP NULL");
        echo "<p>✅ last_login column added</p>";
    } else {
        echo "<p>✅ last_login column exists</p>";
    }
    
    // Create user_sessions table if not exists
    $result = $conn->query("SHOW TABLES LIKE 'user_sessions'");
    if ($result->num_rows == 0) {
        echo "<p>📝 Creating user_sessions table...</p>";
        $sql = "CREATE TABLE user_sessions (
            id INT(11) PRIMARY KEY AUTO_INCREMENT,
            user_id INT(11) NOT NULL,
            session_token VARCHAR(255) NOT NULL UNIQUE,
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            expires_at TIMESTAMP NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->query($sql);
        echo "<p>✅ user_sessions table created</p>";
    } else {
        echo "<p>✅ user_sessions table exists</p>";
    }
    
    // Show current users
    echo "<h3>📋 Current Users:</h3>";
    $result = $conn->query("SELECT id, email, first_name, last_name, is_active, is_verified FROM users");
    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Email</th><th>Name</th><th>Active</th><th>Verified</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
            echo "<td>" . ($row['is_active'] ? 'Yes' : 'No') . "</td>";
            echo "<td>" . ($row['is_verified'] ? 'Yes' : 'No') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>❌ No users found!</p>";
    }
    
} else {
    echo "<p>❌ Table 'users' does not exist!</p>";
}

$conn->close();
echo "<p>✅ Database structure fixed!</p>";
echo "<p><a href='wowdash-php/sign-in.php'>Test Login sekarang</a></p>";
?> 