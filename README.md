# Sistem Peminjaman Alat Elektronik

Sebuah sistem manajemen web berbasis PHP dengan arsitektur MVC untuk mengelola peminjaman dan pengembalian peralatan elektronik di institusi atau perusahaan.

## 📋 Fitur Aplikasi

### Admin
- ✅ CRUD Data User
- ✅ CRUD Kategori Alat
- ✅ CRUD Daftar Alat
- ✅ Kelola Peminjaman
- ✅ Kelola Pengembalian
- ✅ Lihat Log Aktivitas
- ✅ Login/Logout

### Petugas
- ✅ Menyetujui/Menolak Peminjaman
- ✅ Mencatat Pengembalian Alat
- ✅ Membuat Laporan Bulanan
- ✅ Memantau Aktivitas
- ✅ Login/Logout

### Peminjam
- ✅ Melihat Daftar Alat Tersedia
- ✅ Mengajukan Peminjaman
- ✅ Melihat Riwayat Peminjaman
- ✅ Mengembalikan Alat
- ✅ Login/Logout

## 🗄️ Database Structure

Aplikasi menggunakan 7 tabel utama:

1. **users** - Data pengguna dengan role berbeda
2. **kategori** - Kategori alat elektronik
3. **alat** - Data peralatan elektronik
4. **peminjaman** - Permintaan dan data peminjaman
5. **pengembalian** - Data pengembalian dan kondisi alat
6. **log_aktivitas** - Pencatatan setiap aktivitas sistem
7. **laporan** - Laporan statistik bulanan

## 🚀 Instalasi

### Persyaratan Sistem
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache/Nginx dengan mod_rewrite
- Laragon atau localhost equivalent

### Langkah-Langkah Instalasi

1. **Ekstrak file ke folder web server**
   ```bash
   C:\laragon\www\peminjaman_alat_elektronik\
   ```

2. **Buat database MySQL**
   - Buka phpMyAdmin
   - Buat database baru
   - Import file `database.sql`
   
   Atau gunakan command line:
   ```bash
   mysql -u root < database.sql
   ```

3. **Konfigurasi database** (jika berbeda)
   - Edit file `config/database.php`
   - Sesuaikan host, username, password, dan nama database

4. **Akses aplikasi**
   - Buka browser
   - Masuk ke: `http://localhost/peminjaman_alat_elektronik/`

## 👤 Akun Default

Sistem dilengkapi dengan 3 akun default untuk testing:

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| Petugas | petugas | petugas123 |
| Peminjam | peminjam | peminjam123 |

**Catatan:** Segera ubah password ini setelah instalasi untuk keamanan.

## 📁 Struktur Folder

```
peminjaman_alat_elektronik/
├── app/
│   ├── models/          # Model class untuk database operations
│   ├── controllers/     # Controller untuk business logic
│   └── views/           # Template HTML
├── config/
│   └── database.php     # Konfigurasi koneksi database
├── public/
│   └── css/
│       └── style.css    # Stylesheet
├── database.sql         # SQL dump untuk membuat tabel
├── index.php            # Entry point aplikasi
README.md                # File dokumentasi ini
```

## 🔧 Fitur Teknis

### MVC Architecture
- **Model**: Menangani semua operasi database (CRUD)
- **Controller**: Menangani logika bisnis dan request handling
- **View**: Template HTML dengan output dinamis

### Security
- Input validation dengan `htmlspecialchars()`
- Password hashing dengan SHA256
- Session-based authentication
- Role-based access control

### Database
- PDO untuk database abstraction
- Prepared statements untuk mencegah SQL injection
- Relational integrity dengan foreign keys
- Timestamps untuk audit trail

## 📊 Role dan Permission

### Admin
- Akses penuh ke semua menu
- Kelola data master (user, kategori, alat)
- Kelola peminjaman dan pengembalian
- Lihat log aktivitas

### Petugas
- Approve/Reject peminjaman
- Catat pengembalian alat
- Buat laporan bulanan
- Lihat dashboard statistik

### Peminjam
- Lihat alat yang tersedia
- Ajukan peminjaman
- Lihat riwayat peminjaman
- Kembalikan alat yang dipinjam

## 📝 Log Aktivitas

Setiap aktivitas pengguna (login, CRUD, approval) dicatat otomatis dalam `log_aktivitas` dengan informasi:
- User ID
- Jenis aksi
- Deskripsi detail
- IP address
- Timestamp

## 💰 Sistem Denda

Denda otomatis dihitung saat pengembalian alat:
- **Rp 50.000 per hari** untuk pengembalian terlambat
- Dihitung berdasarkan selisih tanggal kembali estimasi dengan aktual
- Dicatat dalam data pengembalian

## 🎨 UI/UX

- Design responsif (mobile-friendly)
- Dashboard dengan statistik real-time
- Form validation
- Alert/notification untuk aksi
- Breadcrumb navigation
- Dark/Light compatible

## 🐛 Troubleshooting

### Database Connection Error
- Pastikan MySQL server sudah running
- Cek konfigurasi di `config/database.php`
- Verifikasi username dan password

### Session Lost After Login
- Pastikan PHP session support aktif
- Check folder `tmp` untuk file session
- Verifikasi cookie settings

### Permission Denied Error
- Pastikan folder `app/views` memiliki akses read
- Check file permissions di server

## 📞 Support

Untuk masalah teknis, silakan:
1. Cek error log di browser console
2. Verifikasi struktur database
3. Pastikan semua file sudah terupload dengan benar

## 📄 Lisensi

Sistem ini adalah project pembelajaran open source.

   **username dan password:**
   - admin : admin123
   - petugas : petugas12
   - peminjam : peminjam123

**Selamat menggunakan Sistem Peminjaman Alat Elektronik!** 🎉
