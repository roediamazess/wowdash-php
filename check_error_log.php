<?php
// Check error log
echo "<h2>Check Error Log</h2>";

// Get error log path
$error_log_path = ini_get('error_log');
echo "<p><strong>Error log path:</strong> $error_log_path</p>";

// Common error log locations
$common_paths = [
    'C:/xampp/php/logs/php_error_log',
    'C:/xampp/apache/logs/error.log',
    'C:/xampp/apache/logs/php_error_log',
    ini_get('error_log')
];

echo "<h3>Checking common error log locations:</h3>";
foreach ($common_paths as $path) {
    if (file_exists($path)) {
        echo "<p style='color: green;'>✅ Found: $path</p>";
        
        // Read last 20 lines
        $lines = file($path);
        $last_lines = array_slice($lines, -20);
        
        echo "<h4>Last 20 lines from $path:</h4>";
        echo "<div style='background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; font-family: monospace; font-size: 12px; max-height: 400px; overflow-y: auto;'>";
        foreach ($last_lines as $line) {
            echo htmlspecialchars($line) . "<br>";
        }
        echo "</div>";
    } else {
        echo "<p style='color: red;'>❌ Not found: $path</p>";
    }
}

// Test error logging
echo "<h3>Testing error logging:</h3>";
error_log("Test error log message from check_error_log.php at " . date('Y-m-d H:i:s'));
echo "<p style='color: green;'>✅ Test error log message sent</p>";

// Check if we can write to error log
echo "<h3>Testing error log write permission:</h3>";
$test_message = "Test write permission at " . date('Y-m-d H:i:s');
if (error_log($test_message)) {
    echo "<p style='color: green;'>✅ Error log write successful</p>";
} else {
    echo "<p style='color: red;'>❌ Error log write failed</p>";
}

echo "<h3>✅ Error log check completed!</h3>";
?> 