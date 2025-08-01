<?php
// Test Save Activity
// File: test_save_activity.php

require_once './partials/db_connection.php';
require_once './detail_activities_functions.php';

echo "<h2>Test Save Activity</h2>";

// Simulate POST data
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

echo "<h3>POST Data:</h3>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

try {
    $manager = new DetailActivitiesManager($conn);
    
    // Test create activity
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
    
    echo "<h3>Processed Data:</h3>";
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    
    $result = $manager->createActivity($data);
    
    if ($result) {
        echo "<p style='color: green;'>✓ Activity created successfully! ID: " . $result . "</p>";
        
        // Verify the created activity
        $createdActivity = $manager->getActivityById($result);
        if ($createdActivity) {
            echo "<h3>Created Activity:</h3>";
            echo "<pre>";
            print_r($createdActivity);
            echo "</pre>";
        }
    } else {
        echo "<p style='color: red;'>✗ Failed to create activity</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='detail-activities.php'>Go to Detail Activities Page</a></p>";
?> 