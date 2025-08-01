<?php
// Test JSON output only
// File: test_json_only.php

// Start output buffering
ob_start();

// Clear any existing output
ob_clean();

// Set content type
header('Content-Type: application/json');

// Simulate successful response
$response = [
    'success' => true,
    'message' => 'Activity created successfully',
    'id' => 42
];

echo json_encode($response);

// End output buffering and send
ob_end_flush();
exit();
?> 