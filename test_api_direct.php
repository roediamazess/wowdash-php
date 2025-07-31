<?php
// Test script for API users - Direct test without cURL

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing API users directly...\n";

// Simulate POST data
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array();

// Test data
$testData = array(
    'userId' => 'USR004',
    'userName' => 'Direct Test User',
    'userTier' => 'Tier 2',
    'startWork' => '2024-03-15',
    'userRole' => 'Developer',
    'userEmail' => 'direct.test@example.com',
    'birthday' => '1992-06-20'
);

// Simulate JSON input
$input = json_encode($testData);
file_put_contents('php://input', $input);

echo "Test data: " . $input . "\n";

// Include and test the API
try {
    ob_start();
    include_once __DIR__ . '/api-user.php';
    $output = ob_get_clean();
    
    echo "API Output: " . $output . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Check database
echo "\nChecking database for added user...\n";
include_once __DIR__ . '/partials/db_connection.php';

$sql = "SELECT * FROM users WHERE user_id = 'USR004'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "User found in database:\n";
    print_r($user);
} else {
    echo "User not found in database\n";
}

// Show all users
echo "\nAll users in database:\n";
$sql = "SELECT * FROM users ORDER BY user_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "- " . $row['user_id'] . ": " . $row['user_name'] . " (" . $row['user_tier'] . ")\n";
    }
} else {
    echo "No users found in database\n";
}

$conn->close();
echo "Test completed.\n";
?> 