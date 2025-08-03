<?php
// Test API langsung
echo "<h2>Test API Direct</h2>";

// Data test
$testData = [
    'userId' => 'AB',
    'userName' => 'AKBAR TJ',
    'userTier' => 'Tier 3',
    'startWork' => '2025-08-04',
    'userRole' => 'User',
    'userEmail' => 'mamat@powerpro.id',
    'password' => 'test123',
    'birthday' => '1990-01-01'
];

echo "<h3>Test Data:</h3>";
echo "<pre>" . json_encode($testData, JSON_PRETTY_PRINT) . "</pre>";

// Test dengan cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Ultimate-Dashboard/wowdash-php/api-user-test.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $headerSize);
$body = substr($response, $headerSize);

curl_close($ch);

echo "<h3>HTTP Code: $httpCode</h3>";
echo "<h3>Headers:</h3>";
echo "<pre>" . htmlspecialchars($headers) . "</pre>";
echo "<h3>Response Body:</h3>";
echo "<pre>" . htmlspecialchars($body) . "</pre>";

// Test JSON parsing
$jsonData = json_decode($body, true);
if ($jsonData === null) {
    echo "<h3 style='color: red;'>❌ JSON Parse Error:</h3>";
    echo "<p>" . json_last_error_msg() . "</p>";
} else {
    echo "<h3 style='color: green;'>✅ JSON Parse Success:</h3>";
    echo "<pre>" . json_encode($jsonData, JSON_PRETTY_PRINT) . "</pre>";
}
?> 