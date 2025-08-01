<?php
// Debug Save Activity
// File: debug_save.php

require_once './partials/db_connection.php';
require_once './detail_activities_functions.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Debug Save Activity</h2>";

// Simulate AJAX request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
    'action' => 'create_activity',
    'project_id' => 'TEST-PRJ-001',
    'information_date' => '2025-01-08',
    'user_position' => 'Ridwan',
    'department' => 'Kitchen',
    'application' => 'AP8 - Cloud AP',
    'type' => 'Setup',
    'description' => 'Test trial untuk membuat activity',
    'action_solution' => 'Test solution',
    'due_date' => '2025-01-15',
    'status' => 'Open',
    'cnc_number' => 'TEST-CNC-001'
];

echo "<h3>Testing AJAX Handler</h3>";

try {
    // This will trigger the AJAX handler
    $manager = new DetailActivitiesManager($conn);
    
    // Test direct function call
    $data = [
        'project_id' => $_POST['project_id'],
        'information_date' => $_POST['information_date'],
        'user_position' => $_POST['user_position'],
        'department' => $_POST['department'],
        'application' => $_POST['application'],
        'type' => $_POST['type'],
        'description' => $_POST['description'],
        'action_solution' => $_POST['action_solution'],
        'due_date' => $_POST['due_date'],
        'status' => $_POST['status'],
        'cnc_number' => $_POST['cnc_number'],
        'created_by' => 1
    ];
    
    echo "<h4>Direct Function Call:</h4>";
    $result = $manager->createActivity($data);
    
    if ($result) {
        echo "<p style='color: green;'>✓ Direct call successful! ID: " . $result . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Direct call failed</p>";
    }
    
    // Check error log
    echo "<h4>Error Log Check:</h4>";
    $errorLog = error_get_last();
    if ($errorLog) {
        echo "<pre>Last Error: ";
        print_r($errorLog);
        echo "</pre>";
    } else {
        echo "<p>No errors in error log</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Exception: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<p><a href='detail-activities.php'>Go to Detail Activities Page</a></p>";
?> 