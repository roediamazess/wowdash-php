<?php
// Setup Database Script
// File: setup_database.php

require_once './partials/db_connection.php';

echo "<h2>Database Setup for Detail Activities</h2>";

try {
    // Read SQL file
    $sqlFile = './detail_activities_simple.sql';
    if (!file_exists($sqlFile)) {
        echo "<p style='color: red;'>Error: SQL file not found!</p>";
        exit;
    }
    
    $sqlContent = file_get_contents($sqlFile);
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sqlContent)));
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            try {
                $result = $conn->query($statement);
                if ($result) {
                    $successCount++;
                    echo "<p style='color: green;'>✓ Success: " . substr($statement, 0, 50) . "...</p>";
                } else {
                    // Check if it's a duplicate key error (which is okay)
                    if (strpos($conn->error, 'Duplicate entry') !== false) {
                        $successCount++;
                        echo "<p style='color: blue;'>ℹ Info: " . substr($conn->error, 0, 50) . "...</p>";
                    } else {
                        $errorCount++;
                        echo "<p style='color: orange;'>⚠ Warning: " . $conn->error . "</p>";
                    }
                }
            } catch (Exception $e) {
                // Check if it's a duplicate key error (which is okay)
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $successCount++;
                    echo "<p style='color: blue;'>ℹ Info: " . substr($e->getMessage(), 0, 50) . "...</p>";
                } else {
                    $errorCount++;
                    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
                }
            }
        }
    }
    
    echo "<hr>";
    echo "<h3>Setup Summary:</h3>";
    echo "<p>Successful operations: <strong style='color: green;'>$successCount</strong></p>";
    echo "<p>Errors/Warnings: <strong style='color: red;'>$errorCount</strong></p>";
    
    // Verify tables were created
    echo "<hr>";
    echo "<h3>Verification:</h3>";
    
    $tables = ['applications', 'detail_activities'];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "<p style='color: green;'>✓ Table '$table' exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Table '$table' missing</p>";
        }
    }
    
    if ($errorCount == 0) {
        echo "<p style='color: green; font-weight: bold;'>✅ Database setup completed successfully!</p>";
        echo "<p><a href='detail-activities.php'>Go to Detail Activities</a></p>";
    } else {
        echo "<p style='color: orange;'>⚠ Setup completed with some warnings. Please check the errors above.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Fatal Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Manual Setup Instructions:</h3>";
echo "<p>If automatic setup fails, please:</p>";
echo "<ol>";
echo "<li>Open phpMyAdmin</li>";
echo "<li>Select your database</li>";
echo "<li>Go to SQL tab</li>";
echo "<li>Copy and paste the content of <code>detail_activities_simple.sql</code></li>";
echo "<li>Click Execute</li>";
echo "</ol>";

echo "<hr>";
echo "<h3>Quick Test:</h3>";
echo "<p><a href='detail-activities.php'>Test Detail Activities Page</a></p>";
?> 