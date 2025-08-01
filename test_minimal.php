<?php
// Minimal test for JSON output
// File: test_minimal.php

// Start output buffering
ob_start();

// Clear any existing output
ob_clean();

// Set content type
header('Content-Type: application/json');

// Test JSON output
$response = [
    'success' => true,
    'message' => 'Test successful',
    'id' => 123
];

echo json_encode($response);

// End output buffering and send
ob_end_flush();
exit();
?> 