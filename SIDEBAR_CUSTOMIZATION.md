# Sidebar Customization - Users Menu Items

## Overview
Telah dilakukan penyesuaian background pada sidebar untuk menu Users > All Users dan Users > Profile Settings.

## Perubahan yang Dilakukan

### 1. CSS Custom Styling
- **File**: `assets/css/sidebar-custom.css`
- **File**: `wowdash-php/assets/css/sidebar-custom.css`
- **File**: `documentation/assets/css/sidebar-custom.css`

### 2. CSS Integration
- **File**: `assets/css/style.css`
- **File**: `wowdash-php/assets/css/style.css`
- **File**: `documentation/assets/css/style.css`

### 3. HTML Head Integration
- **File**: `partials/head.php`
- **File**: `wowdash-php/partials/head.php`
- **File**: `documentation/basic-components.html`

## Styling yang Diterapkan

### Background Color
- **Default**: `var(--brand)` (brand color)
- **Text Color**: `#fff` (white)
- **Border Radius**: `8px`
- **Margin**: `2px 0`

### Hover Effects
- **Background**: Tetap `var(--brand)`
- **Text Color**: Tetap `#fff`
- **Transform**: `translateX(5px)` untuk efek slide

### Active State
- **Background**: `var(--brand)`
- **Text Color**: `#fff`
- **Box Shadow**: `0 2px 8px rgba(0, 0, 0, 0.15)`

### Dark Mode Support
- Semua styling dipertahankan dalam dark mode
- Background dan text color tetap konsisten

## Menu Items yang Disesuaikan

1. **Users > All Users** (`users-list.php`)
   - Background: Brand color
   - Text: White
   - Hover effect: Slide animation

2. **Users > Profile Settings** (`profile-settings.php`)
   - Background: Brand color
   - Text: White
   - Hover effect: Slide animation

## File yang Dimodifikasi

### CSS Files
- `assets/css/sidebar-custom.css` (new)
- `wowdash-php/assets/css/sidebar-custom.css` (new)
- `documentation/assets/css/sidebar-custom.css` (new)
- `assets/css/style.css` (modified)
- `wowdash-php/assets/css/style.css` (modified)
- `documentation/assets/css/style.css` (modified)

### HTML Files
- `partials/head.php` (modified)
- `wowdash-php/partials/head.php` (modified)
- `documentation/basic-components.html` (modified)

## Cara Kerja

1. **CSS Specificity**: Menggunakan `!important` untuk memastikan styling diterapkan
2. **Attribute Selectors**: Menggunakan `[href="filename.php"]` untuk target spesifik
3. **Dark Mode**: Mendukung tema gelap dengan `[data-theme=dark]`
4. **Responsive**: Styling bekerja di semua ukuran layar

## Testing

Untuk memastikan styling bekerja dengan baik:

1. Buka halaman `users-list.php`
2. Buka halaman `profile-settings.php`
3. Periksa sidebar menu Users
4. Test hover effects
5. Test dark mode toggle

## Notes

- Styling menggunakan `!important` untuk override default CSS
- Efek hover menggunakan `transform: translateX(5px)`
- Box shadow ditambahkan untuk active state
- Semua styling konsisten antara light dan dark mode 