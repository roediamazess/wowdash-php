<?php
// Check database status

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== DATABASE STATUS CHECK ===\n\n";

// Include database connection
include_once __DIR__ . '/partials/db_connection.php';

echo "1. Database Connection:\n";
if ($conn->ping()) {
    echo "   ✓ Database connection successful\n";
} else {
    echo "   ✗ Database connection failed\n";
    exit;
}

echo "\n2. Database Information:\n";
echo "   Database: db_ultimate\n";
echo "   Server: " . $conn->server_info . "\n";

echo "\n3. Checking Tables:\n";

// Check tiers table
$sql = "SHOW TABLES LIKE 'tiers'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "   ✓ Tiers table exists\n";
    
    // Count tiers
    $sql = "SELECT COUNT(*) as count FROM tiers";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo "   - Number of tiers: " . $row['count'] . "\n";
    
    // Show tiers
    $sql = "SELECT * FROM tiers ORDER BY id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "     * " . $row['tier_code'] . " (" . $row['tier_name'] . ")\n";
    }
} else {
    echo "   ✗ Tiers table does not exist\n";
}

// Check users table
$sql = "SHOW TABLES LIKE 'users'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "   ✓ Users table exists\n";
    
    // Count users
    $sql = "SELECT COUNT(*) as count FROM users";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo "   - Number of users: " . $row['count'] . "\n";
    
    // Show users
    $sql = "SELECT * FROM users ORDER BY user_id LIMIT 5";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "     * " . $row['user_id'] . ": " . $row['user_name'] . " (" . $row['user_tier'] . ")\n";
    }
} else {
    echo "   ✗ Users table does not exist\n";
}

echo "\n4. Error Log Check:\n";
$errorLogFile = __DIR__ . '/error_log.txt';
if (file_exists($errorLogFile)) {
    echo "   ✓ Error log file exists\n";
    $errorLog = file_get_contents($errorLogFile);
    if (!empty($errorLog)) {
        echo "   - Recent errors:\n";
        $lines = explode("\n", $errorLog);
        $recentLines = array_slice($lines, -5); // Last 5 lines
        foreach ($recentLines as $line) {
            if (!empty(trim($line))) {
                echo "     " . trim($line) . "\n";
            }
        }
    } else {
        echo "   - No errors logged\n";
    }
} else {
    echo "   ✗ Error log file does not exist\n";
}

echo "\n5. PHP Configuration:\n";
echo "   - Error reporting: " . (error_reporting() ? 'Enabled' : 'Disabled') . "\n";
echo "   - Display errors: " . (ini_get('display_errors') ? 'On' : 'Off') . "\n";
echo "   - Log errors: " . (ini_get('log_errors') ? 'On' : 'Off') . "\n";

$conn->close();
echo "\n=== CHECK COMPLETED ===\n";
?> 