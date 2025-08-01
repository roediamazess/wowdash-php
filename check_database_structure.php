<?php
// Check Database Structure
// File: check_database_structure.php

require_once './partials/db_connection.php';

echo "<h2>Database Structure Check</h2>";

// Check if detail_activities table exists
$checkTable = $conn->query("SHOW TABLES LIKE 'detail_activities'");
if ($checkTable->num_rows > 0) {
    echo "<h3>✅ Table 'detail_activities' exists</h3>";
    
    // Get table structure
    $structure = $conn->query("DESCRIBE detail_activities");
    echo "<h4>Table Structure:</h4>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    while ($row = $structure->fetch_assoc()) {
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
    
    // Check sample data
    $sampleData = $conn->query("SELECT * FROM detail_activities LIMIT 3");
    echo "<h4>Sample Data:</h4>";
    if ($sampleData->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        $first = true;
        while ($row = $sampleData->fetch_assoc()) {
            if ($first) {
                echo "<tr>";
                foreach (array_keys($row) as $key) {
                    echo "<th>" . $key . "</th>";
                }
                echo "</tr>";
                $first = false;
            }
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No data found in detail_activities table</p>";
    }
    
} else {
    echo "<h3>❌ Table 'detail_activities' does not exist</h3>";
}

// Check if applications table exists
$checkAppsTable = $conn->query("SHOW TABLES LIKE 'applications'");
if ($checkAppsTable->num_rows > 0) {
    echo "<h3>✅ Table 'applications' exists</h3>";
    
    // Get applications structure
    $appsStructure = $conn->query("DESCRIBE applications");
    echo "<h4>Applications Table Structure:</h4>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    while ($row = $appsStructure->fetch_assoc()) {
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
    
    // Check applications sample data
    $appsData = $conn->query("SELECT * FROM applications LIMIT 5");
    echo "<h4>Applications Sample Data:</h4>";
    if ($appsData->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        $first = true;
        while ($row = $appsData->fetch_assoc()) {
            if ($first) {
                echo "<tr>";
                foreach (array_keys($row) as $key) {
                    echo "<th>" . $key . "</th>";
                }
                echo "</tr>";
                $first = false;
            }
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No data found in applications table</p>";
    }
    
} else {
    echo "<h3>❌ Table 'applications' does not exist</h3>";
}

echo "<h3>Database Connection Test:</h3>";
if ($conn->ping()) {
    echo "✅ Database connection is working";
} else {
    echo "❌ Database connection failed";
}

echo "<h3>PHP Error Log Location:</h3>";
echo "Error log: " . ini_get('error_log');
echo "<br>Display errors: " . (ini_get('display_errors') ? 'ON' : 'OFF');
echo "<br>Error reporting: " . error_reporting();
?> 