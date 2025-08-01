<?php
// Test Create Activity
// File: test_create_activity.php

require_once './partials/db_connection.php';
require_once './detail_activities_functions.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test Create Activity</h2>";

// Test data
$testData = [
    'project_id' => 'TEST-PRJ-001',
    'information_date' => '2025-01-08',
    'user_position' => 'Marina',
    'department' => 'Kitchen',
    'application' => 'AR8 - Cloud AR',
    'type' => 'Setup',
    'description' => 'Test trial untuk membuat activity',
    'action_solution' => 'Test solution',
    'due_date' => '2025-01-15',
    'status' => 'Open',
    'cnc_number' => 'TEST-CNC-001',
    'created_by' => 1
];

echo "<h3>Test Data:</h3>";
echo "<pre>";
print_r($testData);
echo "</pre>";

try {
    $manager = new DetailActivitiesManager($conn);
    
    echo "<h3>Testing createActivity function:</h3>";
    
    // Test the function directly
    $result = $manager->createActivity($testData);
    
    if ($result) {
        echo "<p style='color: green;'>✅ Success! Activity created with ID: " . $result . "</p>";
        
        // Verify the data was inserted
        $activity = $manager->getActivityById($result);
        if ($activity) {
            echo "<h4>Inserted Data:</h4>";
            echo "<pre>";
            print_r($activity);
            echo "</pre>";
        }
    } else {
        echo "<p style='color: red;'>❌ Failed to create activity</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Exception: " . $e->getMessage() . "</p>";
}

echo "<h3>Testing AJAX Handler:</h3>";

// Simulate AJAX request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
    'action' => 'create_activity',
    'project_id' => 'TEST-PRJ-002',
    'information_date' => '2025-01-08',
    'user_position' => 'Marina',
    'department' => 'Kitchen',
    'application' => 'AR8 - Cloud AR',
    'type' => 'Setup',
    'description' => 'Test trial untuk membuat activity via AJAX',
    'action_solution' => 'Test solution',
    'due_date' => '2025-01-15',
    'status' => 'Open',
    'cnc_number' => 'TEST-CNC-002'
];

// Capture output
ob_start();
include 'detail_activities_functions.php';
$output = ob_get_clean();

echo "<h4>AJAX Response:</h4>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";

echo "<h3>Database Connection Test:</h3>";
if ($conn->ping()) {
    echo "✅ Database connection is working";
} else {
    echo "❌ Database connection failed";
}

echo "<h3>Error Log Location:</h3>";
echo "Error log: " . ini_get('error_log');
?> 