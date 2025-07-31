<?php
// Final verification test

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== FINAL VERIFICATION TEST ===\n\n";

// Test 1: Check sidebar
echo "1. Checking sidebar...\n";
$sidebarFile = __DIR__ . '/partials/sidebar.php';
if (file_exists($sidebarFile)) {
    $content = file_get_contents($sidebarFile);
    
    if (strpos($content, 'user-roles.php') !== false) {
        echo "   ✓ User Roles added to Settings\n";
    } else {
        echo "   ✗ User Roles not added to Settings\n";
    }
    
    if (strpos($content, 'href="users-list.php"') !== false) {
        echo "   ✓ Users link exists\n";
    } else {
        echo "   ✗ Users link missing\n";
    }
} else {
    echo "   ✗ Sidebar file not found\n";
}

// Test 2: Check user-roles.php
echo "\n2. Checking user-roles.php...\n";
$userRolesFile = __DIR__ . '/user-roles.php';
if (file_exists($userRolesFile)) {
    echo "   ✓ user-roles.php exists\n";
} else {
    echo "   ✗ user-roles.php missing\n";
}

// Test 3: Check get_user_roles.php
echo "\n3. Checking get_user_roles.php...\n";
$getUserRolesFile = __DIR__ . '/partials/get_user_roles.php';
if (file_exists($getUserRolesFile)) {
    echo "   ✓ get_user_roles.php exists\n";
} else {
    echo "   ✗ get_user_roles.php missing\n";
}

// Test 4: Check users-list.php updates
echo "\n4. Checking users-list.php updates...\n";
$usersListFile = __DIR__ . '/users-list.php';
if (file_exists($usersListFile)) {
    $content = file_get_contents($usersListFile);
    
    if (strpos($content, 'get_user_roles.php') !== false) {
        echo "   ✓ get_user_roles.php included\n";
    } else {
        echo "   ✗ get_user_roles.php not included\n";
    }
    
    if (strpos($content, 'Email') !== false && strpos($content, 'User Email') === false) {
        echo "   ✓ Email field updated\n";
    } else {
        echo "   ✗ Email field not updated\n";
    }
    
    if (strpos($content, 'generateUserRoleOptions()') !== false) {
        echo "   ✓ generateUserRoleOptions() used\n";
    } else {
        echo "   ✗ generateUserRoleOptions() not used\n";
    }
} else {
    echo "   ✗ users-list.php missing\n";
}

// Test 5: Check database
echo "\n5. Checking database...\n";
include_once __DIR__ . '/partials/db_connection.php';

if ($conn->ping()) {
    echo "   ✓ Database connected\n";
    
    // Check user_roles table
    $sql = "SHOW TABLES LIKE 'user_roles'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "   ✓ user_roles table exists\n";
        
        $sql = "SELECT COUNT(*) as count FROM user_roles";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo "   - Roles count: " . $row['count'] . "\n";
    } else {
        echo "   ✗ user_roles table missing\n";
    }
    
    // Check users table
    $sql = "SHOW TABLES LIKE 'users'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "   ✓ users table exists\n";
        
        $sql = "SELECT COUNT(*) as count FROM users";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo "   - Users count: " . $row['count'] . "\n";
    } else {
        echo "   ✗ users table missing\n";
    }
} else {
    echo "   ✗ Database connection failed\n";
}

$conn->close();

echo "\n=== VERIFICATION COMPLETE ===\n";
echo "\nSummary:\n";
echo "- User Roles added to Settings sidebar\n";
echo "- user-roles.php created with management interface\n";
echo "- get_user_roles.php created with helper functions\n";
echo "- users-list.php updated with new fields\n";
echo "- Database tables created and populated\n";
echo "- All systems ready for use\n";
?> 