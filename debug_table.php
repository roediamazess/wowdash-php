<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

echo "<h2>Debug Table Structure</h2>";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select database
$conn->select_db($dbname);

// Check if tiers table exists
$result = $conn->query("SHOW TABLES LIKE 'tiers'");
if ($result->num_rows > 0) {
    echo "<p>✅ Table 'tiers' exists</p>";
    
    // Show table structure
    echo "<h3>Table Structure:</h3>";
    $result = $conn->query("DESCRIBE tiers");
    if ($result) {
        echo "<table border='1'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Show table data
    echo "<h3>Table Data:</h3>";
    $result = $conn->query("SELECT * FROM tiers");
    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Created At</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>❌ No data in tiers table</p>";
    }
    
    // Try to query with name column
    echo "<h3>Testing Query:</h3>";
    $result = $conn->query("SELECT id, name, description FROM tiers ORDER BY name");
    if ($result) {
        echo "<p>✅ Query successful</p>";
        echo "<p>Found " . $result->num_rows . " rows</p>";
    } else {
        echo "<p>❌ Query failed: " . $conn->error . "</p>";
    }
    
} else {
    echo "<p>❌ Table 'tiers' does not exist</p>";
}

$conn->close();
?> 