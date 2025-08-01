<?php
// Check Table Structure
// File: check_table_structure.php

require_once './partials/db_connection.php';

echo "<h2>Database Table Structure Check</h2>";

try {
    // Check detail_activities table structure
    echo "<h3>1. Detail Activities Table Structure</h3>";
    $result = $conn->query("DESCRIBE detail_activities");
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
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
    } else {
        echo "Error: " . $conn->error;
    }
    
    echo "<br><h3>2. Applications Table Structure</h3>";
    $result = $conn->query("DESCRIBE applications");
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
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
    } else {
        echo "Error: " . $conn->error;
    }
    
    echo "<br><h3>3. Sample Data Check</h3>";
    
    // Check detail_activities sample data
    $result = $conn->query("SELECT * FROM detail_activities LIMIT 3");
    if ($result && $result->num_rows > 0) {
        echo "<h4>Detail Activities Sample Data:</h4>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        $first = true;
        while ($row = $result->fetch_assoc()) {
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
                echo "<td>" . ($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No detail_activities data found or table doesn't exist<br>";
    }
    
    // Check applications sample data
    $result = $conn->query("SELECT * FROM applications LIMIT 3");
    if ($result && $result->num_rows > 0) {
        echo "<h4>Applications Sample Data:</h4>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        $first = true;
        while ($row = $result->fetch_assoc()) {
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
                echo "<td>" . ($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No applications data found or table doesn't exist<br>";
    }
    
} catch (Exception $e) {
    echo "<h3>Error</h3>";
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?> 