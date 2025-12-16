# Desain Sistem Informasi Alumni (SIAP PAKAI)

## 1. Struktur Database (ERD)

Berikut adalah struktur tabel untuk database `alumni_db`:

### Tabel `users`
Menyimpan data login untuk admin dan alumni.
- `id_user` (INT, PK, Auto Increment)
- `nama` (VARCHAR 100)
- `email` (VARCHAR 100, Unique)
- `password` (VARCHAR 255) - Hash Password
- `role` (ENUM: 'admin', 'alumni')
- `created_at` (DATETIME)

### Tabel `alumni`
Menyimpan data profil alumni.
- `id_alumni` (INT, PK, Auto Increment)
- `id_user` (INT, FK -> users.id_user)
- `npm` (VARCHAR 20, Unique)
- `angkatan` (YEAR)
- `program_studi` (VARCHAR 50)
- `foto` (VARCHAR 255) - Path foto
- `alamat` (TEXT)
- `no_hp` (VARCHAR 20)

### Tabel `tracer_study`
Menyimpan data pekerjaan dan lokasi alumni (untuk GIS).
- `id_tracer` (INT, PK, Auto Increment)
- `id_alumni` (INT, FK -> alumni.id_alumni)
- `status_kerja` (ENUM: 'Bekerja', 'Wiraswasta', 'Lanjut Studi', 'Belum Bekerja')
- `instansi` (VARCHAR 100)
- `jabatan` (VARCHAR 100)
- `latitude` (DECIMAL 10, 8)
- `longitude` (DECIMAL 11, 8)
- `tahun_mulai_kerja` (YEAR)
- `gaji_rata_rata` (VARCHAR 50)

## 2. Use Case Diagram

**Aktor:**
1. **Admin**
2. **Alumni**

**Use Cases:**

*   **Login**: Admin dan Alumni masuk ke sistem.
*   **Registrasi (Alumni)**: Alumni mendaftar akun baru.
*   **Kelola Data Alumni (Admin)**: Admin menambah, mengedit, menghapus, dan memvalidasi data alumni.
*   **Isi Tracer Study (Alumni)**: Alumni mengisi data pekerjaan dan lokasi.
*   **Lihat Peta Persebaran (Semua)**: Melihat marker lokasi alumni di Google Maps.
*   **Lihat Direktori Alumni (Semua)**: Mencari alumni berdasarkan nama/angkatan.
*   **Laporan Tracer Study (Admin)**: Melihat statistik persebaran alumni.

## 3. Flowchart Sistem

### Proses Login
1. User membuka halaman Login.
2. Input Email dan Password.
3. Sistem memvalidasi input.
4. Jika valid -> Cek Role.
   - Jika Admin -> Redirect ke Dashboard Admin.
   - Jika Alumni -> Redirect ke Dashboard Alumni.
5. Jika tidak valid -> Tampilkan pesan error.

### Pengisian Tracer Study
1. Alumni login.
2. Memilih menu "Tracer Study".
3. Mengisi form (Instansi, Jabatan, Tahun, Lokasi di Peta).
4. Klik Simpan.
5. Sistem menyimpan ke tabel `tracer_study`.
6. Data tampil di Peta Persebaran.

## 4. Arsitektur Sistem

*   **Frontend**: HTML5, CSS3 (bisa menggunakan framework seperti Bootstrap), JavaScript (jQuery + Google Maps API).
*   **Backend**: PHP Native (OOP).
*   **Database**: MySQL.
*   **API**: Google Maps JavaScript API untuk visualisasi peta.

**Alur Data (GIS):**
User membuka Peta -> Browser request ke Server -> Server query DB (`SELECT * FROM tracer_study JOIN alumni`) -> Server return JSON Data -> JavaScript parsing JSON -> Loop data -> Create Google Maps Marker untuk setiap data.

## 5. Keamanan Sistem

1.  **Password Hashing**: Menggunakan `password_hash()` (Bcrypt) saat registrasi dan `password_verify()` saat login.
2.  **Session Management**: Menggunakan `$_SESSION` untuk menyimpan status login dan role. Pengecekan session di setiap halaman yang dilindungi.
3.  **Prepared Statements**: Menggunakan PDO Prepared Statements untuk mencegah SQL Injection pada semua query database.
4.  **XSS Protection**: Menggunakan `htmlspecialchars()` saat menampilkan output user ke browser.
