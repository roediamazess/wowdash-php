# Perubahan User ID dari Nomor ke Inisial Nama

## Tanggal Perubahan
2024-12-19

## Deskripsi Perubahan
Mengubah tampilan User ID di tabel user dari nomor ID menjadi inisial nama user untuk meningkatkan keterbacaan dan user experience.

## File yang Diubah

### 1. users-list.php
- **Lokasi**: `/users-list.php`
- **Perubahan**: 
  - Menambahkan fungsi `generateInitials()` untuk menghasilkan inisial dari first_name dan last_name
  - Mengubah query SQL untuk mengambil `first_name` dan `last_name` terpisah
  - Mengganti tampilan `$row["id"]` menjadi `$initials`

### 2. wowdash-php/users-list.php
- **Lokasi**: `/wowdash-php/users-list.php`
- **Perubahan**:
  - Menambahkan fungsi `generateInitials()` yang sama
  - Mengubah query SQL untuk mengambil `first_name` dan `last_name` terpisah
  - Mengganti tampilan `$row["id"]` menjadi `$initials`

### 3. wowdash-php/user-list.php
- **Lokasi**: `/wowdash-php/user-list.php`
- **Perubahan**:
  - Menambahkan fungsi `generateInitials()` yang sama
  - Mengubah query SQL untuk mengambil `first_name` dan `last_name` terpisah
  - Mengganti tampilan `$row["id"]` menjadi `$initials`

### 4. user-list.php
- **Lokasi**: `/user-list.php`
- **Perubahan**:
  - Menambahkan fungsi `generateInitialsFromFullName()` untuk mengekstrak inisial dari nama lengkap
  - Menggunakan `user_name` yang sudah ada dalam database
  - Mengganti tampilan `$row["user_id"]` menjadi `$initials`

## Fungsi yang Ditambahkan

### generateInitials($firstName, $lastName)
```php
function generateInitials($firstName, $lastName) {
    $firstInitial = !empty($firstName) ? strtoupper(substr($firstName, 0, 1)) : '';
    $lastInitial = !empty($lastName) ? strtoupper(substr($lastName, 0, 1)) : '';
    
    if ($firstInitial && $lastInitial) {
        return $firstInitial . $lastInitial;
    } elseif ($firstInitial) {
        return $firstInitial;
    } elseif ($lastInitial) {
        return $lastInitial;
    } else {
        return 'U'; // Default for unknown names
    }
}
```

### generateInitialsFromFullName($fullName)
```php
function generateInitialsFromFullName($fullName) {
    $nameParts = explode(' ', trim($fullName));
    $initials = '';
    
    if (count($nameParts) >= 2) {
        // Take first letter of first name and first letter of last name
        $firstInitial = !empty($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) : '';
        $lastInitial = !empty($nameParts[count($nameParts) - 1]) ? strtoupper(substr($nameParts[count($nameParts) - 1], 0, 1)) : '';
        
        if ($firstInitial && $lastInitial) {
            return $firstInitial . $lastInitial;
        } elseif ($firstInitial) {
            return $firstInitial;
        } elseif ($lastInitial) {
            return $lastInitial;
        }
    } elseif (count($nameParts) == 1) {
        // Single name, take first letter
        return !empty($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) : 'U';
    }
    
    return 'U'; // Default for unknown names
}
```

## Contoh Hasil Perubahan

### Sebelum:
- User ID: `1` → User Name: `System Administrator`
- User ID: `2` → User Name: `John Doe`
- User ID: `3` → User Name: `Jane Smith`
- User ID: `4` → User Name: `Mike Wilson`

### Sesudah:
- User ID: `SA` → User Name: `System Administrator`
- User ID: `JD` → User Name: `John Doe`
- User ID: `JS` → User Name: `Jane Smith`
- User ID: `MW` → User Name: `Mike Wilson`

## Manfaat Perubahan
1. **Keterbacaan yang Lebih Baik**: User ID sekarang lebih mudah diingat dan dikenali
2. **User Experience yang Lebih Baik**: Pengguna dapat dengan cepat mengidentifikasi user berdasarkan inisial
3. **Konsistensi**: Menggunakan standar yang umum digunakan di sistem manajemen user
4. **Keamanan**: Tidak menampilkan ID numerik yang bisa digunakan untuk serangan

## Catatan Teknis
- Perubahan ini hanya mempengaruhi tampilan, tidak mengubah struktur database
- ID numerik tetap disimpan dalam database untuk referensi internal
- Fungsi ini menangani berbagai skenario nama (nama lengkap, nama tunggal, nama kosong)
- Default value 'U' digunakan untuk nama yang tidak dapat diproses 