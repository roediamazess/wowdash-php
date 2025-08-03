<?php
/**
 * Setup Settings Database
 * File: setup_settings_database.php
 * Description: Script untuk membuat database Settings
 */

// Include database connection
include_once __DIR__ . '/partials/db_connection.php';

echo "=== Setup Settings Database ===\n";

try {
    // Read and execute SQL file
    $sqlFile = __DIR__ . '/settings_database.sql';
    
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: $sqlFile");
    }
    
    $sql = file_get_contents($sqlFile);
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        if (empty($statement)) continue;
        
        try {
            if ($conn->query($statement) === TRUE) {
                $successCount++;
                echo "✓ Executed: " . substr($statement, 0, 50) . "...\n";
            } else {
                $errorCount++;
                echo "✗ Error: " . $conn->error . "\n";
                echo "Statement: " . substr($statement, 0, 100) . "...\n";
            }
        } catch (Exception $e) {
            $errorCount++;
            echo "✗ Exception: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n=== Summary ===\n";
    echo "Successful statements: $successCount\n";
    echo "Failed statements: $errorCount\n";
    
    if ($errorCount == 0) {
        echo "\n✅ Settings database setup completed successfully!\n";
        
        // Verify tables were created
        echo "\n=== Verifying Tables ===\n";
        $tables = [
            'project_status',
            'project_type', 
            'applications',
            'project_information',
            'assignment_pic',
            'tier_level',
            'user_roles'
        ];
        
        foreach ($tables as $table) {
            $result = $conn->query("SHOW TABLES LIKE '$table'");
            if ($result->num_rows > 0) {
                echo "✓ Table '$table' exists\n";
                
                // Count records
                $countResult = $conn->query("SELECT COUNT(*) as count FROM $table");
                $count = $countResult->fetch_assoc()['count'];
                echo "  - Records: $count\n";
            } else {
                echo "✗ Table '$table' missing\n";
            }
        }
        
    } else {
        echo "\n❌ Settings database setup completed with errors.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Fatal error: " . $e->getMessage() . "\n";
}

$conn->close();
echo "\nDatabase connection closed.\n";
?> 