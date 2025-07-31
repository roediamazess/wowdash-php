<?php
require_once './partials/db_connection.php';

// Create activity_logs table for SQLite
$sql1 = "CREATE TABLE IF NOT EXISTS activity_logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    information_date DATE NOT NULL,
    user_position VARCHAR(255),
    department VARCHAR(100) NOT NULL,
    application VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    description TEXT,
    solution TEXT,
    due_date DATE,
    status VARCHAR(50) NOT NULL,
    cnc_number VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";

// Create activities table for SQLite (used by activity.php)
$sql2 = "CREATE TABLE IF NOT EXISTS activities (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    information_date DATE,
    user_position VARCHAR(255),
    department VARCHAR(100),
    application VARCHAR(100),
    type VARCHAR(100),
    description TEXT,
    action_solution TEXT,
    due_date DATE,
    status VARCHAR(50),
    cnc_number VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";

// Create customers table for SQLite (used by customer.php)
$sql3 = "CREATE TABLE IF NOT EXISTS customers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    customer_id VARCHAR(50) UNIQUE NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_star INTEGER DEFAULT 0,
    customer_room INTEGER DEFAULT 0,
    customer_outlet INTEGER DEFAULT 0,
    customer_type VARCHAR(100),
    customer_group VARCHAR(100),
    customer_zone VARCHAR(100),
    customer_address TEXT,
    billing VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";

$tables = [
    'activity_logs' => $sql1,
    'activities' => $sql2,
    'customers' => $sql3
];

$success_count = 0;
foreach ($tables as $table_name => $sql) {
    if ($conn->query($sql)) {
        echo "Table '$table_name' created successfully\n";
        $success_count++;
    } else {
        echo "Error creating table '$table_name': " . $conn->error . "\n";
    }
}

echo "\nDatabase migration completed: $success_count tables created/verified\n";

$conn->close();
?>