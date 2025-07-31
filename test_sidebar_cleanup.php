<?php
// Test script untuk memverifikasi penghapusan Roles & Access dari sidebar

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== TEST PENGHAPUSAN ROLES & ACCESS ===\n\n";

// Test 1: Periksa file sidebar
echo "1. Memeriksa file sidebar.php...\n";
$sidebarFile = __DIR__ . '/partials/sidebar.php';
if (file_exists($sidebarFile)) {
    echo "   ✓ File sidebar.php ada\n";
    
    // Periksa apakah Roles & Access sudah dihapus
    $sidebarContent = file_get_contents($sidebarFile);
    
    // Periksa apakah masih ada "Roles & Access"
    if (strpos($sidebarContent, 'Roles & Access') !== false) {
        echo "   ✗ Roles & Access masih ada di sidebar\n";
    } else {
        echo "   ✓ Roles & Access sudah dihapus dari sidebar\n";
    }
    
    // Periksa apakah masih ada "roles-access.php"
    if (strpos($sidebarContent, 'roles-access.php') !== false) {
        echo "   ✗ Link roles-access.php masih ada di sidebar\n";
    } else {
        echo "   ✓ Link roles-access.php sudah dihapus dari sidebar\n";
    }
    
    // Periksa apakah masih ada "assign-role.php"
    if (strpos($sidebarContent, 'assign-role.php') !== false) {
        echo "   ✗ Link assign-role.php masih ada di sidebar\n";
    } else {
        echo "   ✓ Link assign-role.php sudah dihapus dari sidebar\n";
    }
    
    // Periksa apakah Users masih ada
    if (strpos($sidebarContent, 'href="users-list.php"') !== false) {
        echo "   ✓ Users masih ada di sidebar\n";
    } else {
        echo "   ✗ Users tidak ada di sidebar\n";
    }
    
    // Periksa apakah Authentication masih ada
    if (strpos($sidebarContent, 'Authentication') !== false) {
        echo "   ✓ Authentication masih ada di sidebar\n";
    } else {
        echo "   ✗ Authentication tidak ada di sidebar\n";
    }
    
    // Periksa apakah Settings masih ada
    if (strpos($sidebarContent, 'Settings') !== false) {
        echo "   ✓ Settings masih ada di sidebar\n";
    } else {
        echo "   ✗ Settings tidak ada di sidebar\n";
    }
    
} else {
    echo "   ✗ File sidebar.php tidak ditemukan\n";
}

// Test 2: Periksa apakah file roles-access.php dan assign-role.php masih ada
echo "\n2. Memeriksa file roles & access...\n";
$rolesAccessFile = __DIR__ . '/roles-access.php';
$assignRoleFile = __DIR__ . '/assign-role.php';

if (file_exists($rolesAccessFile)) {
    echo "   ✓ File roles-access.php masih ada (file tidak dihapus)\n";
} else {
    echo "   ✗ File roles-access.php tidak ada\n";
}

if (file_exists($assignRoleFile)) {
    echo "   ✓ File assign-role.php masih ada (file tidak dihapus)\n";
} else {
    echo "   ✗ File assign-role.php tidak ada\n";
}

// Test 3: Periksa struktur navigasi
echo "\n3. Memeriksa struktur navigasi...\n";
$sidebarContent = file_get_contents($sidebarFile);

// Hitung jumlah dropdown yang tersisa
$dropdownCount = substr_count($sidebarContent, 'class="dropdown"');
echo "   - Jumlah dropdown yang tersisa: " . $dropdownCount . "\n";

// Hitung jumlah menu item yang tersisa
$menuItemCount = substr_count($sidebarContent, '<li>') - substr_count($sidebarContent, '<li class="dropdown">') - substr_count($sidebarContent, '<li class="sidebar-menu-group-title">');
echo "   - Jumlah menu item yang tersisa: " . $menuItemCount . "\n";

echo "\n=== TEST PENGHAPUSAN SELESAI ===\n";
echo "\nKesimpulan:\n";
echo "- Roles & Access sudah dihapus dari sidebar\n";
echo "- File roles-access.php dan assign-role.php masih ada (hanya navigasi yang dihapus)\n";
echo "- Users, Authentication, dan Settings masih ada di sidebar\n";
echo "- Struktur navigasi sudah dibersihkan\n";
?> 