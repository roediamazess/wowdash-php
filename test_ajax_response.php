<?php
// Test script untuk memverifikasi response JSON dari AJAX handler
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simulate POST request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['action'] = 'create';
$_POST['project_id'] = '1';
$_POST['information_date'] = '2024-01-15';
$_POST['user_position'] = 'Developer';
$_POST['department'] = 'IT';
$_POST['application'] = 'APP001 - Test Application';
$_POST['type'] = 'Bug Fix';
$_POST['description'] = 'Test activity description';
$_POST['action_solution'] = 'Test solution';
$_POST['due_date'] = '2024-01-20';
$_POST['status'] = 'In Progress';
$_POST['cnc_number'] = 'CNC001';

echo "=== TESTING AJAX RESPONSE ===\n";
echo "Simulated POST data:\n";
print_r($_POST);

echo "\nIncluding detail_activities_functions.php...\n";

// Capture output
ob_start();
include 'detail_activities_functions.php';
$output = ob_get_clean();

echo "\nRaw output:\n";
echo $output;

echo "\nOutput length: " . strlen($output) . "\n";

// Try to parse as JSON
$decoded = json_decode($output, true);
if ($decoded === null) {
    echo "\n❌ FAILED: Output is not valid JSON\n";
    echo "JSON error: " . json_last_error_msg() . "\n";
} else {
    echo "\n✅ SUCCESS: Output is valid JSON\n";
    echo "Decoded result:\n";
    print_r($decoded);
}

echo "\n=== TEST COMPLETE ===\n";
?> 