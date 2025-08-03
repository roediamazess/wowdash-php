# Langkah-langkah Debugging Tombol Save User

## Tanggal Debugging
2024-12-19

## Masalah
Tombol "Save User" masih tidak berfungsi setelah perbaikan sebelumnya.

## Langkah-langkah Debugging

### 1. **Cek Database Connection**
```bash
# Akses file untuk mengecek koneksi database
http://localhost/Ultimate-Dashboard/check_db_connection.php
```

**Yang dicek:**
- Koneksi MySQL
- Keberadaan database `db_ultimate`
- Keberadaan tabel `users`
- Struktur tabel
- Jumlah data

### 2. **Setup Database dan Sample Data**
```bash
# Akses file untuk setup database
http://localhost/Ultimate-Dashboard/add_sample_data.php
```

**Yang dilakukan:**
- Membuat database jika belum ada
- Membuat tabel `users` dengan struktur yang benar
- Menambahkan sample data jika tabel kosong

### 3. **Test API Sederhana**
```bash
# Akses file untuk test API
http://localhost/Ultimate-Dashboard/test_simple_api.php
```

**Yang dicek:**
- Apakah API bisa diakses
- Apakah response JSON valid
- Apakah data tersimpan ke database

### 4. **Debug JavaScript di Browser**
1. Buka `user-list.php`
2. Buka Developer Tools (F12)
3. Pilih tab Console
4. Klik tombol "Add New User"
5. Isi form dan klik "Save User"
6. Perhatikan log di console

**Yang dicek:**
- Apakah event listener terpasang
- Apakah data form terambil dengan benar
- Apakah API call berhasil
- Apakah response dari API valid

### 5. **Cek Error Log PHP**
```bash
# Cek error log XAMPP
C:\xampp\apache\logs\error.log
```

**Yang dicek:**
- Error PHP
- Error database
- Error API

## File yang Dibuat untuk Debugging

### 1. check_db_connection.php
- Mengecek koneksi MySQL
- Mengecek keberadaan database dan tabel
- Menampilkan struktur tabel
- Menampilkan jumlah data

### 2. add_sample_data.php
- Menambahkan sample data ke tabel users
- Hanya menambahkan jika tabel kosong

### 3. test_simple_api.php
- Test API dengan data sederhana
- Menampilkan response dalam format JSON
- Menampilkan error jika ada

### 4. debug_api.php
- API sederhana untuk mengecek akses
- Menampilkan semua data request

## Perbaikan yang Dilakukan

### 1. **Database Connection (partials/db_connection.php)**
```php
// Sebelum
$conn = new mysqli($servername, $username, $password, $dbname);

// Sesudah
$conn = new mysqli($servername, $username, $password);
// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);
$conn->select_db($dbname);
// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS users (...)";
$conn->query($sql);
```

### 2. **JavaScript Debugging (user-list.php)**
```javascript
// Menambahkan console.log untuk debugging
console.log('Save User button clicked');
console.log('User data to send:', userData);
console.log('API URL:', 'wowdash-php/api-user.php');
console.log('API response:', data);
```

### 3. **API Call Debugging**
```javascript
// Menambahkan logging untuk API call
console.log('API Call - URL:', url);
console.log('API Call - Body:', body);
console.log('API Call - Response status:', response.status);
console.log('API Call - Response data:', responseData);
```

## Kemungkinan Masalah

### 1. **Database Issues**
- Database `db_ultimate` tidak ada
- Tabel `users` tidak ada
- Struktur tabel tidak sesuai
- Tidak ada sample data

### 2. **Path Issues**
- Path API salah
- File API tidak ditemukan
- Permission issues

### 3. **JavaScript Issues**
- Event listener tidak terpasang
- Data form tidak terambil
- Network error
- CORS issues

### 4. **PHP Issues**
- Error di API
- Database connection error
- Authentication issues

## Langkah Testing

### Step 1: Setup Database
1. Akses `check_db_connection.php`
2. Pastikan semua status hijau (✅)
3. Jika ada error, perbaiki sesuai pesan

### Step 2: Add Sample Data
1. Akses `add_sample_data.php`
2. Pastikan sample data ditambahkan

### Step 3: Test API
1. Akses `test_simple_api.php`
2. Klik "Test API"
3. Pastikan response success

### Step 4: Test Modal
1. Akses `user-list.php`
2. Buka Developer Tools
3. Klik "Add New User"
4. Isi form dan klik "Save User"
5. Perhatikan console log

## Expected Results

### Database Check
```
✅ MySQL connection successful
✅ Database 'db_ultimate' exists
✅ Database connection successful
✅ Table 'users' exists
Number of users: 3
```

### API Test
```json
{
    "success": true,
    "message": "User created successfully. Temporary password: abc123def",
    "data": {
        "id": 4,
        "user_name": "Test User",
        "user_tier": "Tier 3",
        "start_work": "2024-01-01",
        "user_role": "User",
        "user_email": "test@example.com",
        "birthday": "1990-01-01"
    }
}
```

### Console Log
```
Save User button clicked
User data to send: {userName: "Fajar Ahmad Akbar", ...}
API URL: wowdash-php/api-user.php
API Call - URL: wowdash-php/api-user.php
API Call - Body: {userName: "Fajar Ahmad Akbar", ...}
API Call - Response status: 200
API response: {success: true, message: "User created successfully...", ...}
```

## Troubleshooting

### Jika Database Error
1. Pastikan XAMPP MySQL running
2. Pastikan database `db_ultimate` ada
3. Pastikan tabel `users` ada dengan struktur yang benar

### Jika API Error
1. Cek path file API
2. Cek error log PHP
3. Test dengan `debug_api.php`

### Jika JavaScript Error
1. Cek console browser
2. Pastikan semua file JavaScript ter-load
3. Pastikan event listener terpasang

### Jika Network Error
1. Cek apakah server running
2. Cek path URL
3. Cek CORS settings 