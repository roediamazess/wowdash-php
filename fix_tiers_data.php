<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ultimate";

echo "<h2>Fix Tiers Data</h2>";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select database
$conn->select_db($dbname);

// Check current data
echo "<h3>Current Data:</h3>";
$result = $conn->query("SELECT * FROM tiers");
if ($result && $result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Description</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . ($row['name'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['description'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Clear existing data
echo "<p>🗑️ Clearing existing data...</p>";
$conn->query("DELETE FROM tiers");

// Insert correct data
echo "<p>📝 Inserting correct data...</p>";
$default_tiers = [
    ['name' => 'Tier 1', 'description' => 'Basic tier'],
    ['name' => 'Tier 2', 'description' => 'Standard tier'],
    ['name' => 'Tier 3', 'description' => 'Premium tier'],
    ['name' => 'Premium', 'description' => 'Premium tier'],
    ['name' => 'Standard', 'description' => 'Standard tier'],
    ['name' => 'Basic', 'description' => 'Basic tier']
];

foreach ($default_tiers as $tier) {
    $insert_tier = "INSERT INTO tiers (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_tier);
    $stmt->bind_param("ss", $tier['name'], $tier['description']);
    if ($stmt->execute()) {
        echo "<p>✅ Inserted tier: " . $tier['name'] . "</p>";
    } else {
        echo "<p>❌ Error inserting tier " . $tier['name'] . ": " . $stmt->error . "</p>";
    }
}

// Show final data
echo "<h3>Final Data:</h3>";
$result = $conn->query("SELECT * FROM tiers ORDER BY name");
if ($result && $result->num_rows > 0) {
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
}

$conn->close();
echo "<p>✅ Tiers data fixed!</p>";
echo "<p><a href='test_api_simple.php'>Test API sekarang</a></p>";
?> 