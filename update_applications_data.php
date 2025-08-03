<?php
/**
 * Update Applications Data
 * File: update_applications_data.php
 * Description: Script untuk mengupdate data aplikasi dengan app_code
 */

// Include database connection
include_once __DIR__ . '/partials/db_connection.php';

echo "=== Updating Applications Data ===\n";

try {
    // Update existing applications with app_code
    $updateQueries = [
        "UPDATE applications SET app_code = 'POS8', app_name = 'Cloud POS' WHERE app_name = 'POS System'",
        "UPDATE applications SET app_code = 'INV8', app_name = 'Cloud INV' WHERE app_name = 'Inventory System'",
        "UPDATE applications SET app_code = 'FO8', app_name = 'Cloud FO' WHERE app_name = 'Booking System'",
        "UPDATE applications SET app_code = 'AR8', app_name = 'Cloud AR' WHERE app_name = 'Accounting System'",
        "UPDATE applications SET app_code = 'AP8', app_name = 'Cloud AP' WHERE app_name = 'Payroll System'",
        "UPDATE applications SET app_code = 'GL8', app_name = 'Cloud GL' WHERE app_name = 'General Ledger System'"
    ];
    
    foreach ($updateQueries as $query) {
        if ($conn->query($query)) {
            echo "✓ Updated: " . substr($query, 0, 50) . "...\n";
        } else {
            echo "✗ Failed: " . $conn->error . "\n";
        }
    }
    
    // Insert new applications if they don't exist
    $newApps = [
        ['FO8', 'Cloud FO'],
        ['POS8', 'Cloud POS'],
        ['AR8', 'Cloud AR'],
        ['INV8', 'Cloud INV'],
        ['AP8', 'Cloud AP'],
        ['GL8', 'Cloud GL']
    ];
    
    echo "\nInserting new applications...\n";
    foreach ($newApps as $app) {
        $stmt = $conn->prepare("INSERT IGNORE INTO applications (app_code, app_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $app[0], $app[1]);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "✓ Inserted: {$app[0]} - {$app[1]}\n";
            } else {
                echo "ℹ Already exists: {$app[0]} - {$app[1]}\n";
            }
        } else {
            echo "✗ Failed to insert: {$app[0]} - {$app[1]}\n";
        }
    }
    
    // Show final data
    echo "\nFinal applications data:\n";
    $result = $conn->query("SELECT * FROM applications WHERE app_code IS NOT NULL ORDER BY app_code");
    while ($row = $result->fetch_assoc()) {
        echo "  {$row['app_code']} - {$row['app_name']}\n";
    }
    
    echo "\n✅ Applications data updated successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

$conn->close();
echo "\nDatabase connection closed.\n";
?> 