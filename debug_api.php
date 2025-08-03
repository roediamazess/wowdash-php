<?php
// Debug API - untuk mengecek apakah API berfungsi

header('Content-Type: application/json');

echo json_encode([
    'status' => 'API is accessible',
    'timestamp' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'],
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'Not set',
    'input' => file_get_contents('php://input'),
    'post' => $_POST,
    'get' => $_GET
]);
?> 