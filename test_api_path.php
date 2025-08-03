<?php
// Test path file di API

echo "<h2>Testing API File Path</h2>";

// Test apakah file API bisa diakses
$apiFile = 'wowdash-php/api-user.php';

echo "<h3>1. Checking if API file exists</h3>";
if (file_exists($apiFile)) {
    echo "<p style='color: green;'>✅ API file exists: $apiFile</p>";
} else {
    echo "<p style='color: red;'>❌ API file not found: $apiFile</p>";
}

// Test apakah file db_connection.php bisa diakses dari API
$dbFile = 'wowdash-php/partials/db_connection.php';
echo "<h3>2. Checking if database connection file exists</h3>";
if (file_exists($dbFile)) {
    echo "<p style='color: green;'>✅ Database connection file exists: $dbFile</p>";
} else {
    echo "<p style='color: red;'>❌ Database connection file not found: $dbFile</p>";
}

// Test include path
echo "<h3>3. Testing include path</h3>";
$currentDir = __DIR__;
echo "<p>Current directory: $currentDir</p>";

$relativePath = 'wowdash-php/partials/db_connection.php';
$absolutePath = __DIR__ . '/wowdash-php/partials/db_connection.php';

echo "<p>Relative path: $relativePath</p>";
echo "<p>Absolute path: $absolutePath</p>";

if (file_exists($absolutePath)) {
    echo "<p style='color: green;'>✅ Absolute path works</p>";
} else {
    echo "<p style='color: red;'>❌ Absolute path doesn't work</p>";
}

// Test apakah bisa include file
echo "<h3>4. Testing include functionality</h3>";
try {
    // Simulasi include seperti di API
    $testInclude = __DIR__ . '/wowdash-php/partials/db_connection.php';
    if (file_exists($testInclude)) {
        echo "<p style='color: green;'>✅ Include file exists and can be included</p>";
        
        // Test apakah variabel $conn tersedia setelah include
        ob_start();
        include_once $testInclude;
        ob_end_clean();
        
        echo "<p style='color: green;'>✅ Include successful</p>";
    } else {
        echo "<p style='color: red;'>❌ Include file not found</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Include error: " . $e->getMessage() . "</p>";
}

// Test URL accessibility
echo "<h3>5. Testing URL accessibility</h3>";
$testUrl = 'http://localhost/Ultimate-Dashboard/wowdash-php/api-user.php';
echo "<p>Testing URL: $testUrl</p>";

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode(['test' => 'data'])
    ]
]);

$response = @file_get_contents($testUrl, false, $context);
if ($response !== false) {
    echo "<p style='color: green;'>✅ URL is accessible</p>";
    echo "<p>Response length: " . strlen($response) . " characters</p>";
} else {
    echo "<p style='color: red;'>❌ URL is not accessible</p>";
}

echo "<h3>✅ Path test completed!</h3>";
?> 