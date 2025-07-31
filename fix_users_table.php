<?php
// Fix users table script - Change user_id to VARCHAR and populate with proper User IDs
include_once __DIR__ . '/partials/db_connection.php';

echo "=== Fixing Users Table ===\n";

// Drop existing table
$dropSQL = "DROP TABLE IF EXISTS users";
if ($conn->query($dropSQL) === TRUE) {
    echo "✓ Dropped existing users table\n";
} else {
    echo "✗ Error dropping table: " . $conn->error . "\n";
}

// Create new table with VARCHAR user_id
$createSQL = "CREATE TABLE users (
    user_id VARCHAR(50) PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    user_tier VARCHAR(100),
    start_work DATE,
    user_role VARCHAR(100),
    user_email VARCHAR(255),
    birthday DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($createSQL) === TRUE) {
    echo "✓ Created users table with VARCHAR user_id\n";
} else {
    echo "✗ Error creating table: " . $conn->error . "\n";
    exit;
}

// Insert sample data with proper User IDs
$sampleData = array(
    array(
        "user_id" => "USR001",
        "user_name" => "John Doe",
        "user_tier" => "Gold",
        "start_work" => "2023-01-15",
        "user_role" => "Administrator",
        "user_email" => "john.doe@example.com",
        "birthday" => "1990-05-20"
    ),
    array(
        "user_id" => "USR002",
        "user_name" => "Jane Smith",
        "user_tier" => "Silver",
        "start_work" => "2023-02-10",
        "user_role" => "Supervisor",
        "user_email" => "jane.smith@example.com",
        "birthday" => "1988-12-15"
    ),
    array(
        "user_id" => "USR003",
        "user_name" => "Mike Johnson",
        "user_tier" => "Bronze",
        "start_work" => "2023-03-05",
        "user_role" => "User",
        "user_email" => "mike.johnson@example.com",
        "birthday" => "1992-08-30"
    ),
    array(
        "user_id" => "USR004",
        "user_name" => "Sarah Wilson",
        "user_tier" => "Gold",
        "start_work" => "2023-01-20",
        "user_role" => "Admin Officer",
        "user_email" => "sarah.wilson@example.com",
        "birthday" => "1985-11-10"
    ),
    array(
        "user_id" => "USR005",
        "user_name" => "David Brown",
        "user_tier" => "Silver",
        "start_work" => "2023-04-12",
        "user_role" => "Client",
        "user_email" => "david.brown@example.com",
        "birthday" => "1995-03-25"
    )
);

$insertSQL = "INSERT INTO users (user_id, user_name, user_tier, start_work, user_role, user_email, birthday) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertSQL);

$insertedCount = 0;
foreach ($sampleData as $user) {
    $stmt->bind_param("sssssss", 
        $user['user_id'],
        $user['user_name'],
        $user['user_tier'],
        $user['start_work'],
        $user['user_role'],
        $user['user_email'],
        $user['birthday']
    );
    
    if ($stmt->execute()) {
        $insertedCount++;
        echo "✓ Inserted user: " . $user['user_id'] . " - " . $user['user_name'] . "\n";
    } else {
        echo "✗ Error inserting user " . $user['user_id'] . ": " . $stmt->error . "\n";
    }
}

$stmt->close();

echo "\n=== Summary ===\n";
echo "✓ Successfully inserted " . $insertedCount . " users\n";

// Verify the data
echo "\n=== Verification ===\n";
$verifySQL = "SELECT user_id, user_name, user_role FROM users ORDER BY user_id";
$result = $conn->query($verifySQL);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "User ID: " . $row['user_id'] . " | Name: " . $row['user_name'] . " | Role: " . $row['user_role'] . "\n";
    }
} else {
    echo "No users found\n";
}

echo "\n✓ Users table fixed successfully!\n";
?> 