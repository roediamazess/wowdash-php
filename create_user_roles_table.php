<?php
// Create user_roles table script

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Creating user_roles table...\n";

// Include database connection
include_once __DIR__ . '/partials/db_connection.php';

// Create user_roles table
$sql = "CREATE TABLE IF NOT EXISTS user_roles (
    role_id VARCHAR(50) PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'user_roles' created successfully or already exists\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Check if user_roles table is empty and insert default data if needed
$sql = "SELECT COUNT(*) as count FROM user_roles";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo "Inserting default user roles data...\n";
    // Insert default user roles data
    $roles = array(
        array("role_id" => "Administrator", "role_name" => "Me", "description" => "Full system access"),
        array("role_id" => "Supervisor", "role_name" => "Manager", "description" => "Management level access"),
        array("role_id" => "Admin Officer", "role_name" => "Iam", "description" => "Administrative access"),
        array("role_id" => "User", "role_name" => "Team", "description" => "Standard user access"),
        array("role_id" => "Client", "role_name" => "Hotel", "description" => "Client access")
    );
    
    foreach ($roles as $role) {
        $stmt = $conn->prepare("INSERT INTO user_roles (role_id, role_name, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $role['role_id'], $role['role_name'], $role['description']);
        
        if ($stmt->execute()) {
            echo "Role '" . $role['role_id'] . "' inserted successfully\n";
        } else {
            echo "Error inserting role '" . $role['role_id'] . "': " . $stmt->error . "\n";
        }
        
        $stmt->close();
    }
} else {
    echo "User roles data already exists. Skipping default data insertion.\n";
}

$conn->close();
echo "User roles table setup completed.\n";
?> 