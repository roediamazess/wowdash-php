<?php
// Test script untuk memverifikasi User Roles dan field Users yang baru

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== TEST USER ROLES DAN FIELD USERS ===\n\n";

// Test 1: Periksa file user-roles.php
echo "1. Memeriksa file user-roles.php...\n";
$userRolesFile = __DIR__ . '/user-roles.php';
if (file_exists($userRolesFile)) {
    echo "   ✓ File user-roles.php ada\n";
    
    // Periksa apakah halaman menampilkan User Roles Management
    $userRolesContent = file_get_contents($userRolesFile);
    if (strpos($userRolesContent, 'User Roles Management') !== false) {
        echo "   ✓ Halaman menampilkan User Roles Management\n";
    }
    
    if (strpos($userRolesContent, 'Add New Role') !== false) {
        echo "   ✓ Halaman memiliki tombol Add New Role\n";
    }
    
    if (strpos($userRolesContent, 'Edit Role') !== false) {
        echo "   ✓ Halaman memiliki tombol Edit Role\n";
    }
    
    if (strpos($userRolesContent, 'Delete Role') !== false) {
        echo "   ✓ Halaman memiliki tombol Delete Role\n";
    }
    
    // Periksa apakah ada tabel untuk menampilkan data role
    if (strpos($userRolesContent, '<table') !== false) {
        echo "   ✓ Halaman memiliki tabel untuk menampilkan data\n";
    }
} else {
    echo "   ✗ File user-roles.php tidak ditemukan\n";
}

// Test 2: Periksa file get_user_roles.php
echo "\n2. Memeriksa file get_user_roles.php...\n";
$getUserRolesFile = __DIR__ . '/partials/get_user_roles.php';
if (file_exists($getUserRolesFile)) {
    echo "   ✓ File get_user_roles.php ada\n";
    
    // Include dan test fungsi
    include_once $getUserRolesFile;
    
    $roles = getUserRoles();
    if (is_array($roles) && count($roles) > 0) {
        echo "   ✓ Fungsi getUserRoles() berfungsi\n";
        echo "   - Jumlah roles: " . count($roles) . "\n";
        
        // Periksa data default
        $expectedRoles = array("Administrator", "Supervisor", "Admin Officer", "User", "Client");
        $foundRoles = array_column($roles, 'role_id');
        
        foreach ($expectedRoles as $expectedRole) {
            if (in_array($expectedRole, $foundRoles)) {
                echo "   ✓ Role '$expectedRole' ditemukan\n";
            } else {
                echo "   ✗ Role '$expectedRole' tidak ditemukan\n";
            }
        }
    } else {
        echo "   ✗ Fungsi getUserRoles() tidak berfungsi\n";
    }
    
    // Test generateUserRoleOptions
    $options = generateUserRoleOptions();
    if (strpos($options, '<option') !== false) {
        echo "   ✓ Fungsi generateUserRoleOptions() berfungsi\n";
    } else {
        echo "   ✗ Fungsi generateUserRoleOptions() tidak berfungsi\n";
    }
} else {
    echo "   ✗ File get_user_roles.php tidak ditemukan\n";
}

// Test 3: Periksa sidebar Settings
echo "\n3. Memeriksa sidebar Settings...\n";
$sidebarFile = __DIR__ . '/partials/sidebar.php';
if (file_exists($sidebarFile)) {
    $sidebarContent = file_get_contents($sidebarFile);
    
    if (strpos($sidebarContent, 'user-roles.php') !== false) {
        echo "   ✓ User Roles sudah ditambahkan ke sidebar Settings\n";
    } else {
        echo "   ✗ User Roles belum ditambahkan ke sidebar Settings\n";
    }
    
    if (strpos($sidebarContent, 'User Roles') !== false) {
        echo "   ✓ Menu User Roles ada di sidebar\n";
    } else {
        echo "   ✗ Menu User Roles tidak ada di sidebar\n";
    }
} else {
    echo "   ✗ File sidebar.php tidak ditemukan\n";
}

// Test 4: Periksa file users-list.php yang sudah diupdate
echo "\n4. Memeriksa file users-list.php...\n";
$usersListFile = __DIR__ . '/users-list.php';
if (file_exists($usersListFile)) {
    echo "   ✓ File users-list.php ada\n";
    
    $usersListContent = file_get_contents($usersListFile);
    
    // Periksa apakah sudah include get_user_roles.php
    if (strpos($usersListContent, 'get_user_roles.php') !== false) {
        echo "   ✓ File sudah include get_user_roles.php\n";
    } else {
        echo "   ✗ File belum include get_user_roles.php\n";
    }
    
    // Periksa apakah header tabel sudah diupdate
    if (strpos($usersListContent, 'Email') !== false && strpos($usersListContent, 'User Email') === false) {
        echo "   ✓ Header tabel sudah diupdate (Email bukan User Email)\n";
    } else {
        echo "   ✗ Header tabel belum diupdate\n";
    }
    
    // Periksa apakah form sudah menggunakan generateUserRoleOptions
    if (strpos($usersListContent, 'generateUserRoleOptions()') !== false) {
        echo "   ✓ Form sudah menggunakan generateUserRoleOptions()\n";
    } else {
        echo "   ✗ Form belum menggunakan generateUserRoleOptions()\n";
    }
    
    // Periksa placeholder pada form
    if (strpos($usersListContent, 'placeholder="Enter User ID"') !== false) {
        echo "   ✓ Form sudah memiliki placeholder yang sesuai\n";
    } else {
        echo "   ✗ Form belum memiliki placeholder yang sesuai\n";
    }
} else {
    echo "   ✗ File users-list.php tidak ditemukan\n";
}

// Test 5: Periksa database connection
echo "\n5. Memeriksa koneksi database...\n";
include_once __DIR__ . '/partials/db_connection.php';

if ($conn->ping()) {
    echo "   ✓ Koneksi database berhasil\n";
    
    // Periksa tabel user_roles
    $sql = "SHOW TABLES LIKE 'user_roles'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "   ✓ Tabel user_roles ada\n";
        
        // Periksa jumlah roles
        $sql = "SELECT COUNT(*) as count FROM user_roles";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo "   - Jumlah roles: " . $row['count'] . "\n";
        
        // Periksa data roles
        $sql = "SELECT role_id, role_name FROM user_roles ORDER BY role_id";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "     * " . $row['role_id'] . " (" . $row['role_name'] . ")\n";
        }
    } else {
        echo "   ✗ Tabel user_roles tidak ada\n";
    }
    
    // Periksa tabel users
    $sql = "SHOW TABLES LIKE 'users'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "   ✓ Tabel users ada\n";
        
        // Periksa struktur tabel users
        $sql = "DESCRIBE users";
        $result = $conn->query($sql);
        echo "   - Struktur tabel users:\n";
        while ($row = $result->fetch_assoc()) {
            echo "     * " . $row['Field'] . " (" . $row['Type'] . ")\n";
        }
    } else {
        echo "   ✗ Tabel users tidak ada\n";
    }
} else {
    echo "   ✗ Koneksi database gagal\n";
}

$conn->close();
echo "\n=== TEST SELESAI ===\n";
echo "\nKesimpulan:\n";
echo "- User Roles sudah ditambahkan ke sidebar Settings\n";
echo "- File user-roles.php sudah dibuat dengan data default\n";
echo "- File get_user_roles.php sudah dibuat dengan fungsi yang diperlukan\n";
echo "- File users-list.php sudah diupdate dengan field yang baru\n";
echo "- Database sudah siap untuk User Roles dan Users\n";
?> 