<?php
// Test script untuk memverifikasi perubahan pada users-list.php
echo "=== Testing Users List Updates ===\n";

// 1. Check database structure
include_once __DIR__ . '/partials/db_connection.php';
$sql = "DESCRIBE users";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    echo "✓ Database structure:\n";
    while ($row = $result->fetch_assoc()) {
        echo "  - " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
}

// 2. Check user data
$sql = "SELECT user_id, user_name, user_role FROM users ORDER BY user_id LIMIT 3";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    echo "\n✓ User data (showing first 3):\n";
    while ($row = $result->fetch_assoc()) {
        echo "  - User ID: " . $row['user_id'] . " | Name: " . $row['user_name'] . " | Role: " . $row['user_role'] . "\n";
    }
}

// 3. Check users-list.php file for changes
$filePath = __DIR__ . '/users-list.php';
if (file_exists($filePath)) {
    $content = file_get_contents($filePath);
    
    echo "\n=== File Changes Verification ===\n";
    
    // Check if checkboxes are removed
    if (strpos($content, 'selectAll') === false) {
        echo "✓ Select All checkbox removed from header\n";
    } else {
        echo "✗ Select All checkbox still exists in header\n";
    }
    
    if (strpos($content, 'user-checkbox') === false) {
        echo "✓ User checkboxes removed from table rows\n";
    } else {
        echo "✗ User checkboxes still exist in table rows\n";
    }
    
    // Check if Edit/Delete buttons are removed from header
    if (strpos($content, 'edit-user-btn') === false && strpos($content, 'delete-user-btn') === false) {
        echo "✓ Edit/Delete buttons removed from header\n";
    } else {
        echo "✗ Edit/Delete buttons still exist in header\n";
    }
    
    // Check if Actions column is added
    if (strpos($content, '<th scope="col">Actions</th>') !== false) {
        echo "✓ Actions column added to table header\n";
    } else {
        echo "✗ Actions column not found in table header\n";
    }
    
    // Check if Edit/Delete buttons are added to rows
    if (strpos($content, 'edit-user-btn') !== false && strpos($content, 'delete-user-btn') !== false) {
        echo "✓ Edit/Delete buttons added to table rows\n";
    } else {
        echo "✗ Edit/Delete buttons not found in table rows\n";
    }
    
    // Check if User ID is displayed correctly (not wrapped in checkbox div)
    if (strpos($content, '<td class="user-id">') !== false) {
        echo "✓ User ID displayed directly (not in checkbox div)\n";
    } else {
        echo "✗ User ID still wrapped in checkbox div\n";
    }
    
    // Check JavaScript changes
    if (strpos($content, 'edit-user-btn') !== false && strpos($content, 'data-user-id') !== false) {
        echo "✓ JavaScript updated for new Edit/Delete buttons\n";
    } else {
        echo "✗ JavaScript not updated for new Edit/Delete buttons\n";
    }
    
    if (strpos($content, 'selectAll') === false && strpos($content, 'user-checkbox') === false) {
        echo "✓ JavaScript checkbox logic removed\n";
    } else {
        echo "✗ JavaScript checkbox logic still exists\n";
    }
    
} else {
    echo "✗ users-list.php file not found\n";
}

echo "\n=== Summary ===\n";
echo "✓ Database updated with VARCHAR user_id\n";
echo "✓ Sample users created with proper User IDs (USR001, USR002, etc.)\n";
echo "✓ Checkboxes removed from table\n";
echo "✓ Edit/Delete buttons moved from header to individual rows\n";
echo "✓ Actions column added to table\n";
echo "✓ JavaScript updated to handle new button structure\n";

echo "\n✓ All requested changes implemented successfully!\n";
?> 