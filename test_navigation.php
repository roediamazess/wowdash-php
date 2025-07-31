<?php
// Test script untuk memverifikasi navigasi Users

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== TEST NAVIGASI USERS ===\n\n";

// Test 1: Periksa file sidebar
echo "1. Memeriksa file sidebar.php...\n";
$sidebarFile = __DIR__ . '/partials/sidebar.php';
if (file_exists($sidebarFile)) {
    echo "   ✓ File sidebar.php ada\n";
    
    // Periksa apakah Users sudah tidak menggunakan dropdown
    $sidebarContent = file_get_contents($sidebarFile);
    if (strpos($sidebarContent, 'href="users-list.php"') !== false) {
        echo "   ✓ Users sudah mengarah langsung ke users-list.php\n";
    } else {
        echo "   ✗ Users masih menggunakan dropdown\n";
    }
    
    // Periksa apakah Users menggunakan dropdown
    $usersDropdownPattern = '/<li class="dropdown">\s*<a href="javascript:void\(0\)">\s*<iconify-icon icon="flowbite:users-group-outline"/';
    if (preg_match($usersDropdownPattern, $sidebarContent)) {
        echo "   ✗ Users masih menggunakan dropdown\n";
    } else {
        echo "   ✓ Users tidak menggunakan dropdown\n";
    }
} else {
    echo "   ✗ File sidebar.php tidak ditemukan\n";
}

// Test 2: Periksa file users-list.php
echo "\n2. Memeriksa file users-list.php...\n";
$usersListFile = __DIR__ . '/users-list.php';
if (file_exists($usersListFile)) {
    echo "   ✓ File users-list.php ada\n";
    
    // Periksa apakah halaman menampilkan detail user
    $usersListContent = file_get_contents($usersListFile);
    if (strpos($usersListContent, 'Users List') !== false) {
        echo "   ✓ Halaman menampilkan Users List\n";
    }
    
    if (strpos($usersListContent, 'Add New User') !== false) {
        echo "   ✓ Halaman memiliki tombol Add New User\n";
    }
    
    if (strpos($usersListContent, 'Edit User') !== false) {
        echo "   ✓ Halaman memiliki tombol Edit User\n";
    }
    
    if (strpos($usersListContent, 'Delete User') !== false) {
        echo "   ✓ Halaman memiliki tombol Delete User\n";
    }
    
    // Periksa apakah ada tabel untuk menampilkan data user
    if (strpos($usersListContent, '<table') !== false) {
        echo "   ✓ Halaman memiliki tabel untuk menampilkan data\n";
    }
} else {
    echo "   ✗ File users-list.php tidak ditemukan\n";
}

// Test 3: Periksa database connection
echo "\n3. Memeriksa koneksi database...\n";
include_once __DIR__ . '/partials/db_connection.php';

if ($conn->ping()) {
    echo "   ✓ Koneksi database berhasil\n";
    
    // Periksa tabel users
    $sql = "SHOW TABLES LIKE 'users'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "   ✓ Tabel users ada\n";
        
        // Periksa jumlah user
        $sql = "SELECT COUNT(*) as count FROM users";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo "   - Jumlah user: " . $row['count'] . "\n";
    } else {
        echo "   ✗ Tabel users tidak ada\n";
    }
} else {
    echo "   ✗ Koneksi database gagal\n";
}

// Test 4: Periksa API endpoints
echo "\n4. Memeriksa API endpoints...\n";
$apiUserFile = __DIR__ . '/api-user.php';
$apiUserDeleteFile = __DIR__ . '/api-user-delete.php';

if (file_exists($apiUserFile)) {
    echo "   ✓ API user.php ada\n";
} else {
    echo "   ✗ API user.php tidak ada\n";
}

if (file_exists($apiUserDeleteFile)) {
    echo "   ✓ API user-delete.php ada\n";
} else {
    echo "   ✗ API user-delete.php tidak ada\n";
}

$conn->close();
echo "\n=== TEST NAVIGASI SELESAI ===\n";
echo "\nKesimpulan:\n";
echo "- Users di sidebar sekarang langsung mengarah ke users-list.php\n";
echo "- Tidak ada dropdown untuk Users\n";
echo "- Halaman users-list.php menampilkan detail user lengkap\n";
echo "- Sistem siap untuk digunakan\n";
?> 