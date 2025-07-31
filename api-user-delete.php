<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Keep this off for production security
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

header('Content-Type: application/json');
include_once __DIR__ . '/partials/db_connection.php';

function send_response($success, $message, $data = null) {
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
    exit;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    send_response(false, 'Invalid request method.');
}

// Get the input data
$input = file_get_contents('php://input');
if ($input === false) {
    http_response_code(400);
    send_response(false, 'Failed to read request body.');
}
error_log("api-user-delete.php: Received raw input: " . $input); // Log the raw input

$data = json_decode($input, true);

// Check if JSON decoding was successful and if userIds is set and is an array
if (json_last_error() !== JSON_ERROR_NONE || !$data || !isset($data['userIds']) || !is_array($data['userIds'])) {
    http_response_code(400);
    error_log("api-user-delete.php: Invalid JSON or missing userIds array. JSON error: " . json_last_error_msg());
    send_response(false, 'Invalid JSON data or missing user IDs array.');
}

$userIds = $data['userIds'];
if (empty($userIds)) {
    send_response(false, 'No user IDs provided.');
}

// Sanitize and validate user IDs
$sanitizedUserIds = [];
foreach ($userIds as $userId) {
    $sanitizedId = trim($userId);
    if (!empty($sanitizedId)) {
        $sanitizedUserIds[] = $sanitizedId;
    }
}

if (empty($sanitizedUserIds)) {
    http_response_code(400);
    send_response(false, 'No valid user IDs provided.');
}

error_log("api-user-delete.php: Attempting to delete users with IDs: " . implode(', ', $sanitizedUserIds));

global $conn;

try {
    $placeholders = implode(',', array_fill(0, count($sanitizedUserIds), '?'));
    $types = str_repeat('s', count($sanitizedUserIds));

    $stmt = $conn->prepare("DELETE FROM users WHERE user_id IN ($placeholders)");
    if (!$stmt) {
        http_response_code(500);
        error_log('Prepare failed: ' . $conn->error);
        send_response(false, 'Database prepare failed. Check server logs.');
    }
    
    $stmt->bind_param($types, ...$sanitizedUserIds);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        send_response(true, $stmt->affected_rows . ' user(s) deleted successfully.');
    } else {
        http_response_code(404); // Not Found
        send_response(false, 'No users found with the provided IDs or they were already deleted.');
    }
    $stmt->close();
    
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    error_log('MySQLi Exception: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
    send_response(false, 'A database error occurred. Please check server logs.');
} catch (Exception $e) {
    http_response_code(500);
    error_log('Exception: ' . $e->getMessage());
    send_response(false, 'A server error occurred.');
}
?>