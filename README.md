# 📄 Arsip Surat Desa Karangduren

Aplikasi web untuk mengarsipkan dan mengelola surat-surat resmi Kelurahan Karangduren. Sistem ini memungkinkan petugas untuk menyimpan, mencari, dan menampilkan kembali surat-surat resmi dalam format PDF dengan sistem kategorisasi yang terorganisir.

## 🎯 Tujuan Aplikasi

- Mempermudah pengelolaan arsip surat-surat resmi kelurahan
- Menyediakan sistem pencarian yang efisien untuk menemukan surat
- Memastikan dokumentasi surat tersimpan dengan aman dalam format digital
- Memberikan akses mudah untuk preview dan download surat

## ✨ Fitur Utama

### 📋 Manajemen Surat
- **Upload Surat PDF**: Upload file PDF hasil scan surat resmi
- **Pencarian Surat**: Pencarian berdasarkan judul surat
- **Preview Surat**: Tampilan preview PDF dengan anti-IDM bypass
- **Download Surat**: Download file PDF yang telah diarsipkan
- **Detail Surat**: Informasi lengkap nomor surat, kategori, dan waktu pengarsipan

### 🏷️ Manajemen Kategori
- **CRUD Kategori**: Tambah, edit, hapus kategori surat
- **Pencarian Kategori**: Cari kategori berdasarkan nama
- **Validasi Relasi**: Proteksi hapus kategori yang masih memiliki surat
- **Kategori Default**: Undangan, Pengumuman, Nota Dinas, Pemberitahuan

### 👤 Halaman About
- **Informasi Developer**: Data pembuat aplikasi
- **Tanggal Pembuatan**: Informasi waktu pengembangan aplikasi

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL 8.0
- **Frontend**: Bootstrap 5.3, Font Awesome 6.0
- **JavaScript**: SweetAlert2 untuk notifikasi
- **File Storage**: Laravel Storage dengan symbolic link
- **PDF Handling**: Browser native dengan fallback strategies

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/arsip-surat-desa-karangduren.git
cd arsip-surat-desa-karangduren
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
Import database yang disediakan:
```bash
mysql -u root -p < database_export.sql
```

Atau buat database baru dan jalankan migration:
```sql
CREATE DATABASE arsip_surat_desa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arsip_surat_desa
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Migration & Seeder (Jika tidak import database)
```bash
php artisan migrate --seed
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Set Permissions (Linux/Mac)
```bash
chmod -R 755 storage bootstrap/cache
```

### 8. Run Application
```bash
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000`

## 📊 Struktur Database

### Tabel `kategoris`
```sql
- id (Primary Key, Auto Increment)
- nama_kategori (VARCHAR 255, Unique)
- deskripsi (TEXT, Nullable)
- created_at, updated_at (Timestamps)
```

### Tabel `surats`
```sql
- id (Primary Key, Auto Increment)
- nomor_surat (VARCHAR 255, Unique)
- kategori_id (Foreign Key to kategoris.id)
- judul (VARCHAR 255)
- file_path (VARCHAR 255)
- waktu_pengarsipan (DATETIME)
- created_at, updated_at (Timestamps)
```

## 🚀 Cara Penggunaan

### Mengelola Surat
1. **Tambah Surat**: Klik tombol "Arsipkan Surat.." di halaman utama
2. **Upload File**: Pilih file PDF (maksimal 10MB)
3. **Isi Data**: Masukkan nomor surat, kategori, dan judul
4. **Simpan**: Klik tombol "Simpan" untuk menyimpan surat

### Mencari Surat
1. **Search Bar**: Gunakan kolom pencarian untuk mencari berdasarkan judul
2. **Filter Kategori**: Lihat surat berdasarkan kategori di menu Kategori Surat

### Melihat & Download Surat
1. **Preview**: Klik tombol "Lihat >>" untuk melihat detail dan preview PDF
2. **Download**: Klik tombol "Unduh" untuk mendownload file PDF
3. **Hapus**: Klik tombol "Hapus" dengan konfirmasi untuk menghapus surat

### Mengelola Kategori
1. **Lihat Kategori**: Akses menu "Kategori Surat" di sidebar
2. **Tambah Kategori**: Klik "Tambah Kategori Baru"
3. **Edit Kategori**: Klik tombol "Edit" pada kategori yang ingin diubah
4. **Hapus Kategori**: Hapus kategori yang tidak memiliki surat terkait

## 📁 Struktur File

```
arsip-surat-desa-karangduren/
├── app/
│   ├── Http/Controllers/
│   │   ├── SuratController.php
│   │   └── KategoriController.php
│   └── Models/
│       ├── Surat.php
│       └── Kategori.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── surat/ (CRUD views)
│   ├── kategori/ (CRUD views)
│   └── about.blade.php
├── storage/app/public/surat-files/ (PDF storage)
├── database_export.sql (Database export)
└── README.md
```

## 🔒 Keamanan

- **File Validation**: Hanya file PDF yang diizinkan untuk upload
- **File Size Limit**: Maksimal 10MB per file
- **Path Traversal Protection**: Validasi nama file untuk mencegah path traversal
- **Character Sanitization**: Pembersihan karakter ilegal dalam nama file

## 🎨 Fitur UI/UX

- **Responsive Design**: Kompatibel dengan desktop dan mobile
- **Bootstrap 5**: Interface yang modern dan clean
- **SweetAlert2**: Notifikasi yang menarik dan interaktif
- **Font Awesome**: Icon yang konsisten di seluruh aplikasi
- **Anti-IDM Strategy**: Multiple fallback untuk preview PDF

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 License

Project ini menggunakan [MIT License](LICENSE).

## 👨‍💻 Developer

**Nama**: [Isi Nama Anda]  
**NIM**: [Isi NIM Anda]  
**Program Studi**: [Isi Program Studi Anda]  
**Tanggal**: [Isi Tanggal Pembuatan]

## 📞 Support

Jika mengalami masalah atau memiliki pertanyaan, silakan buat issue di repository ini.

---

⭐ **Jangan lupa berikan star jika project ini membantu!** ⭐
