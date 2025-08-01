<?php
// Update Detail Activities Table Structure
// File: update_detail_activities_table.php

require_once './partials/db_connection.php';

try {
    echo "Updating detail_activities table structure...\n";
    
    // Check if detail_activities table exists
    $checkTable = $conn->query("SHOW TABLES LIKE 'detail_activities'");
    if ($checkTable->num_rows == 0) {
        echo "detail_activities table does not exist. Please run setup_database.php first.\n";
        exit;
    }
    
    // Check current application_id column definition
    $checkColumn = $conn->query("SHOW COLUMNS FROM detail_activities LIKE 'application_id'");
    if ($checkColumn->num_rows > 0) {
        $columnInfo = $checkColumn->fetch_assoc();
        echo "Current application_id column: " . $columnInfo['Type'] . " " . $columnInfo['Null'] . "\n";
        
        // If it's not INT NULL, update it
        if ($columnInfo['Type'] !== 'int(11)' || $columnInfo['Null'] !== 'YES') {
            echo "Updating application_id column to INT NULL...\n";
            $alterResult = $conn->query("ALTER TABLE detail_activities MODIFY COLUMN application_id INT NULL");
            if ($alterResult) {
                echo "Successfully updated application_id column to INT NULL\n";
            } else {
                echo "Failed to update application_id column: " . $conn->error . "\n";
            }
        } else {
            echo "application_id column is already correctly defined as INT NULL\n";
        }
    } else {
        echo "application_id column does not exist. Please run setup_database.php first.\n";
    }
    
    // Check if applications table exists and has correct structure
    $checkAppsTable = $conn->query("SHOW TABLES LIKE 'applications'");
    if ($checkAppsTable->num_rows == 0) {
        echo "applications table does not exist. Creating it...\n";
        $createAppsTable = $conn->query("
            CREATE TABLE applications (
                id INT AUTO_INCREMENT PRIMARY KEY,
                app_code VARCHAR(20) UNIQUE,
                app_name VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");
        if ($createAppsTable) {
            echo "Successfully created applications table\n";
        } else {
            echo "Failed to create applications table: " . $conn->error . "\n";
        }
    } else {
        echo "applications table exists\n";
        
        // Check if it has the correct columns
        $checkAppCode = $conn->query("SHOW COLUMNS FROM applications LIKE 'app_code'");
        $checkAppName = $conn->query("SHOW COLUMNS FROM applications LIKE 'app_name'");
        
        if ($checkAppCode->num_rows == 0 || $checkAppName->num_rows == 0) {
            echo "Updating applications table structure...\n";
            
            // Add app_code column if it doesn't exist
            if ($checkAppCode->num_rows == 0) {
                $conn->query("ALTER TABLE applications ADD COLUMN app_code VARCHAR(20) UNIQUE AFTER id");
                echo "Added app_code column\n";
            }
            
            // Add app_name column if it doesn't exist
            if ($checkAppName->num_rows == 0) {
                $conn->query("ALTER TABLE applications ADD COLUMN app_name VARCHAR(100) NOT NULL AFTER app_code");
                echo "Added app_name column\n";
            }
        } else {
            echo "applications table has correct structure\n";
        }
    }
    
    echo "Database structure update completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 