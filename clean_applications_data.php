<?php
/**
 * Clean Applications Data
 * File: clean_applications_data.php
 * Description: Script untuk membersihkan data applications dan memasukkan data baru
 */

// Include database connection
include_once __DIR__ . '/partials/db_connection.php';

echo "=== Cleaning Applications Data ===\n";

try {
    // Clear existing data
    echo "Clearing existing applications data...\n";
    $conn->query("DELETE FROM applications");
    echo "✓ Existing data cleared\n";
    
    // Insert new applications data
    echo "\nInserting new applications data...\n";
    $newApps = [
        ['FO8', 'Cloud FO'],
        ['POS8', 'Cloud POS'],
        ['AR8', 'Cloud AR'],
        ['INV8', 'Cloud INV'],
        ['AP8', 'Cloud AP'],
        ['GL8', 'Cloud GL']
    ];
    
    foreach ($newApps as $app) {
        $stmt = $conn->prepare("INSERT INTO applications (app_code, app_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $app[0], $app[1]);
        if ($stmt->execute()) {
            echo "✓ Inserted: {$app[0]} - {$app[1]}\n";
        } else {
            echo "✗ Failed to insert: {$app[0]} - {$app[1]}\n";
        }
    }
    
    // Show final data
    echo "\nFinal applications data:\n";
    $result = $conn->query("SELECT * FROM applications ORDER BY app_code");
    while ($row = $result->fetch_assoc()) {
        echo "  {$row['app_code']} - {$row['app_name']}\n";
    }
    
    echo "\n✅ Applications data cleaned and updated successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

$conn->close();
echo "\nDatabase connection closed.\n";
?> 