<?php
// Test database connection and session
// File: test_db_connection.php

// Start session
session_start();

// Include database connection
require_once './partials/db_connection.php';

// Set content type
header('Content-Type: application/json');

// Test database connection
if ($conn) {
    echo json_encode(['success' => true, 'message' => 'Database connected successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
}

exit();
?> 