<?php
/**
 * Check Settings Tables
 * File: check_settings_tables.php
 * Description: Script untuk memeriksa struktur tabel Settings
 */

// Include database connection
include_once __DIR__ . '/partials/db_connection.php';

echo "=== Checking Settings Tables ===\n";

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
    echo "\n--- Table: $table ---\n";
    
    // Check if table exists
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "✓ Table exists\n";
        
        // Show table structure
        $structure = $conn->query("DESCRIBE $table");
        echo "Structure:\n";
        while ($row = $structure->fetch_assoc()) {
            echo "  - {$row['Field']}: {$row['Type']} " . 
                 ($row['Null'] == 'NO' ? 'NOT NULL' : 'NULL') . 
                 ($row['Key'] ? " ({$row['Key']})" : "") . "\n";
        }
        
        // Count records
        $countResult = $conn->query("SELECT COUNT(*) as count FROM $table");
        $count = $countResult->fetch_assoc()['count'];
        echo "  Records: $count\n";
        
        // Show sample data
        if ($count > 0) {
            $sampleResult = $conn->query("SELECT * FROM $table LIMIT 3");
            echo "  Sample data:\n";
            while ($row = $sampleResult->fetch_assoc()) {
                echo "    " . json_encode($row) . "\n";
            }
        }
        
    } else {
        echo "✗ Table does not exist\n";
    }
}

$conn->close();
echo "\nDatabase connection closed.\n";
?> 