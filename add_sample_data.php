<?php
// Add sample data to users table

include_once __DIR__ . '/partials/db_connection.php';

// Check if table has data
$result = $conn->query("SELECT COUNT(*) as count FROM users");
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    echo "<h2>Adding Sample Data</h2>";
    
    $sample_users = [
        [
            'username' => 'admin',
            'email' => 'admin@ultimate-dashboard.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'user_role' => 'Super Admin',
            'user_tier' => 'Tier 3',
            'start_work' => '2024-01-01',
            'birthday' => '1990-01-01',
            'is_active' => 1,
            'is_verified' => 1
        ],
        [
            'username' => 'john.doe',
            'email' => 'john.doe@company.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_role' => 'Manager',
            'user_tier' => 'Premium',
            'start_work' => '2024-01-15',
            'birthday' => '1990-05-20',
            'is_active' => 1,
            'is_verified' => 1
        ],
        [
            'username' => 'jane.smith',
            'email' => 'jane.smith@company.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'user_role' => 'User',
            'user_tier' => 'Standard',
            'start_work' => '2024-03-10',
            'birthday' => '1988-12-15',
            'is_active' => 1,
            'is_verified' => 1
        ]
    ];
    
    foreach ($sample_users as $user) {
        $sql = "INSERT INTO users (username, email, password, first_name, last_name, user_tier, user_role, start_work, birthday, is_active, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssii", 
            $user['username'],
            $user['email'],
            $user['password'],
            $user['first_name'],
            $user['last_name'],
            $user['user_tier'],
            $user['user_role'],
            $user['start_work'],
            $user['birthday'],
            $user['is_active'],
            $user['is_verified']
        );
        
        if ($stmt->execute()) {
            echo "<p style='color: green;'>✅ Inserted user: " . $user['username'] . "</p>";
        } else {
            echo "<p style='color: red;'>❌ Error inserting user " . $user['username'] . ": " . $stmt->error . "</p>";
        }
    }
    
    echo "<h3>✅ Sample data added successfully!</h3>";
} else {
    echo "<h2>Database already has " . $row['count'] . " users</h2>";
    echo "<p>No need to add sample data.</p>";
}

$conn->close();
?> 