<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

header('Content-Type: application/json');
include_once __DIR__ . '/partials/db_connection.php';

function send_response($success, $message, $data = null) {
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    send_response(false, 'Invalid request method.');
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE || !$data) {
    http_response_code(400);
    send_response(false, 'Invalid JSON data.');
}

// --- Validasi ---
$userId = trim($data['userId'] ?? '');
$userName = trim($data['userName'] ?? '');
$userTier = trim($data['userTier'] ?? '');
$startWork = !empty($data['startWork']) ? trim($data['startWork']) : null;
$userRole = trim($data['userRole'] ?? '');
$userEmail = trim($data['userEmail'] ?? '');
$birthday = !empty($data['birthday']) ? trim($data['birthday']) : null;

if (empty($userId)) {
    http_response_code(400);
    send_response(false, 'User ID is required.');
}
if (empty($userName)) {
    http_response_code(400);
    send_response(false, 'User Name is required.');
}
if (!empty($userEmail) && !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    send_response(false, 'Invalid email format.');
}
// --- Akhir Validasi ---

global $conn;

try {
    // Menggunakan INSERT ... ON DUPLICATE KEY UPDATE untuk menangani tambah dan update
    $sql = "INSERT INTO users (user_id, user_name, user_tier, start_work, user_role, user_email, birthday) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            user_name = VALUES(user_name), 
            user_tier = VALUES(user_tier), 
            start_work = VALUES(start_work), 
            user_role = VALUES(user_role), 
            user_email = VALUES(user_email), 
            birthday = VALUES(birthday)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        error_log('Prepare failed: ' . $conn->error);
        send_response(false, 'Database prepare failed.');
    }

    $stmt->bind_param("sssssss", $userId, $userName, $userTier, $startWork, $userRole, $userEmail, $birthday);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = $stmt->affected_rows === 1 ? 'User added successfully.' : 'User updated successfully.';
        $returnData = $data;
        send_response(true, $message, $returnData);
    } else {
        send_response(true, 'No changes were made to the user data.', $data);
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