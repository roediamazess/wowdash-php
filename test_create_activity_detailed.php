<?php
// Test script untuk menguji fungsi createActivity dengan logging detail
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'test_error.log');

// Include database connection
require_once './partials/db_connection.php';

// Include the functions file
require_once 'detail_activities_functions.php';

echo "=== DETAILED CREATE ACTIVITY TEST ===\n";

try {
    // Create manager instance
    $manager = new DetailActivitiesManager($conn);
    echo "✅ Manager created successfully\n";

    // Test data
    $test_data = [
        'project_id' => '1',
        'information_date' => '2024-01-15',
        'user_position' => 'Developer',
        'department' => 'IT',
        'application' => 'APP001 - Test Application',
        'type' => 'Bug Fix',
        'description' => 'Test activity description',
        'action_solution' => 'Test solution',
        'due_date' => '2024-01-20',
        'status' => 'In Progress',
        'cnc_number' => 'CNC001',
        'created_by' => 1
    ];

    echo "Test data:\n";
    print_r($test_data);

    echo "\nCalling createActivity function...\n";

    // Call the function
    $result = $manager->createActivity($test_data);

    echo "\nResult:\n";
    print_r($result);

    if ($result['success']) {
        echo "\n✅ SUCCESS: Activity created with ID: " . $result['id'] . "\n";
    } else {
        echo "\n❌ FAILED: " . $result['message'] . "\n";
    }

    // Check if the record was actually inserted
    if ($result['success']) {
        $check_sql = "SELECT * FROM detail_activities WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param('i', $result['id']);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $row = $check_result->fetch_assoc();
            echo "\n✅ VERIFICATION: Record found in database:\n";
            print_r($row);
        } else {
            echo "\n❌ VERIFICATION FAILED: Record not found in database\n";
        }
        $check_stmt->close();
    }

} catch (Exception $e) {
    echo "\n❌ EXCEPTION: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
} catch (Error $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
?> 