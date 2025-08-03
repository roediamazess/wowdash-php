<?php
// List all databases

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully\n";

// List all databases
$sql = "SHOW DATABASES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Databases:\n";
    while($row = $result->fetch_assoc()) {
        echo "- " . $row['Database'] . "\n";
    }
} else {
    echo "No databases found.\n";
}

$conn->close();
?>
