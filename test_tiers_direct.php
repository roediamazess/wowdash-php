<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

echo "<h2>Test Tiers Direct</h2>";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select database
$conn->select_db($dbname);

// Clear and recreate tiers table
echo "<p>🗑️ Dropping and recreating tiers table...</p>";
$conn->query("DROP TABLE IF EXISTS tiers");

$sql = "CREATE TABLE tiers (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<p>✅ Table 'tiers' created successfully</p>";
    
    // Insert data
    $tiers = [
        ['name' => 'Tier 1', 'description' => 'Basic tier'],
        ['name' => 'Tier 2', 'description' => 'Standard tier'],
        ['name' => 'Tier 3', 'description' => 'Premium tier'],
        ['name' => 'Premium', 'description' => 'Premium tier'],
        ['name' => 'Standard', 'description' => 'Standard tier'],
        ['name' => 'Basic', 'description' => 'Basic tier']
    ];
    
    foreach ($tiers as $tier) {
        $insert_sql = "INSERT INTO tiers (name, description) VALUES ('" . $tier['name'] . "', '" . $tier['description'] . "')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "<p>✅ Inserted: " . $tier['name'] . "</p>";
        } else {
            echo "<p>❌ Error inserting " . $tier['name'] . ": " . $conn->error . "</p>";
        }
    }
    
    // Test query
    echo "<h3>Testing Query:</h3>";
    $result = $conn->query("SELECT * FROM tiers ORDER BY name");
    if ($result && $result->num_rows > 0) {
        echo "<p>✅ Query successful! Found " . $result->num_rows . " tiers:</p>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Description</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>❌ Query failed or no data found</p>";
    }
    
} else {
    echo "<p>❌ Error creating table: " . $conn->error . "</p>";
}

$conn->close();
echo "<p>✅ Test completed!</p>";
?> 