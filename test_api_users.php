<?php
// Test script for API users

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing API users...\n";

// Test data
$testData = array(
    'userId' => 'USR003',
    'userName' => 'Test User',
    'userTier' => 'Tier 1',
    'startWork' => '2024-03-01',
    'userRole' => 'Tester',
    'userEmail' => 'test.user@example.com',
    'birthday' => '1995-12-10'
);

// Convert to JSON
$jsonData = json_encode($testData);

echo "Sending test data: " . $jsonData . "\n";

// Create cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Ultimate-Dashboard/wowdash-php/api-user.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Response Code: " . $httpCode . "\n";
echo "Response: " . $response . "\n";

// Test database connection and check if user was added
echo "\nChecking database for added user...\n";
include_once __DIR__ . '/partials/db_connection.php';

$sql = "SELECT * FROM users WHERE user_id = 'USR003'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "User found in database:\n";
    print_r($user);
} else {
    echo "User not found in database\n";
}

$conn->close();
echo "Test completed.\n";
?> 