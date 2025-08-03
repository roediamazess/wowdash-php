<?php
// Create users table script

// Include database connection
include_once __DIR__ . '/partials/db_connection.php';

echo "Creating users table...\n";

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
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

if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully or already exists\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Check if users table is empty and insert sample data if needed
$sql = "SELECT COUNT(*) as count FROM users";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo "Inserting sample user data...\n";
    // Insert sample user data
    $users = array(
        array(
            "user_id" => "USR001",
            "user_name" => "John Doe",
            "user_tier" => "New Born",
            "start_work" => "2024-01-15",
            "user_role" => "Developer",
            "user_email" => "john.doe@example.com",
            "birthday" => "1990-05-15"
        ),
        array(
            "user_id" => "USR002",
            "user_name" => "Jane Smith",
            "user_tier" => "Tier 1",
            "start_work" => "2024-02-01",
            "user_role" => "Designer",
            "user_email" => "jane.smith@example.com",
            "birthday" => "1988-08-22"
        )
    );
    
    foreach ($users as $user) {
        $stmt = $conn->prepare("INSERT INTO users (user_id, user_name, user_tier, start_work, user_role, user_email, birthday) VALUES (?, ?, ?, ?, ?, ?, ?)");
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
            echo "User '" . $user['user_name'] . "' inserted successfully\n";
        } else {
            echo "Error inserting user '" . $user['user_name'] . "': " . $stmt->error . "\n";
        }
        
        $stmt->close();
    }
} else {
    echo "User data already exists. Skipping sample data insertion.\n";
}

$conn->close();
echo "Users table setup completed.\n";
?> 