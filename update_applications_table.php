<?php
/**
 * Update Applications Table
 * File: update_applications_table.php
 * Description: Script untuk mengupdate struktur tabel applications
 */

// Include database connection
include_once __DIR__ . '/partials/db_connection.php';

echo "=== Updating Applications Table ===\n";

try {
    // Check current structure
    echo "Current structure:\n";
    $result = $conn->query("DESCRIBE applications");
    while ($row = $result->fetch_assoc()) {
        echo "  - {$row['Field']}: {$row['Type']} " . 
             ($row['Null'] == 'NO' ? 'NOT NULL' : 'NULL') . 
             ($row['Key'] ? " ({$row['Key']})" : "") . "\n";
    }
    
    // Add app_code column if not exists
    $checkColumn = $conn->query("SHOW COLUMNS FROM applications LIKE 'app_code'");
    if ($checkColumn->num_rows == 0) {
        echo "\nAdding app_code column...\n";
        $conn->query("ALTER TABLE applications ADD COLUMN app_code VARCHAR(20) UNIQUE AFTER id");
        echo "✓ app_code column added\n";
    } else {
        echo "\n✓ app_code column already exists\n";
    }
    
    // Add updated_at column if not exists
    $checkUpdatedAt = $conn->query("SHOW COLUMNS FROM applications LIKE 'updated_at'");
    if ($checkUpdatedAt->num_rows == 0) {
        echo "Adding updated_at column...\n";
        $conn->query("ALTER TABLE applications ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        echo "✓ updated_at column added\n";
    } else {
        echo "✓ updated_at column already exists\n";
    }
    
    // Rename 'name' column to 'app_name' if needed
    $checkName = $conn->query("SHOW COLUMNS FROM applications LIKE 'name'");
    $checkAppName = $conn->query("SHOW COLUMNS FROM applications LIKE 'app_name'");
    
    if ($checkName->num_rows > 0 && $checkAppName->num_rows == 0) {
        echo "Renaming 'name' column to 'app_name'...\n";
        $conn->query("ALTER TABLE applications CHANGE name app_name VARCHAR(100) NOT NULL");
        echo "✓ Column renamed\n";
    } else {
        echo "✓ Column structure is correct\n";
    }
    
    // Insert default data
    echo "\nInserting default data...\n";
    $defaultApps = [
        ['FO8', 'Cloud FO'],
        ['POS8', 'Cloud POS'],
        ['AR8', 'Cloud AR'],
        ['INV8', 'Cloud INV'],
        ['AP8', 'Cloud AP'],
        ['GL8', 'Cloud GL']
    ];
    
    foreach ($defaultApps as $app) {
        $stmt = $conn->prepare("INSERT IGNORE INTO applications (app_code, app_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $app[0], $app[1]);
        if ($stmt->execute()) {
            echo "✓ Inserted: {$app[0]} - {$app[1]}\n";
        } else {
            echo "✗ Failed to insert: {$app[0]} - {$app[1]}\n";
        }
    }
    
    // Show final structure
    echo "\nFinal structure:\n";
    $finalResult = $conn->query("DESCRIBE applications");
    while ($row = $finalResult->fetch_assoc()) {
        echo "  - {$row['Field']}: {$row['Type']} " . 
             ($row['Null'] == 'NO' ? 'NOT NULL' : 'NULL') . 
             ($row['Key'] ? " ({$row['Key']})" : "") . "\n";
    }
    
    // Show sample data
    echo "\nSample data:\n";
    $sampleResult = $conn->query("SELECT * FROM applications LIMIT 5");
    while ($row = $sampleResult->fetch_assoc()) {
        echo "  " . json_encode($row) . "\n";
    }
    
    echo "\n✅ Applications table updated successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

$conn->close();
echo "\nDatabase connection closed.\n";
?> 