# Struktur Database Sirkra

## 1. tabel_pendaftar — Data Pendaftar Kunjungan

| Nama Kolom | Tipe Data | Keterangan |
|---|---|---|
| id_pendaftar | bigint(20) AUTO_INCREMENT | Primary Key — ID unik pendaftar |
| jenis_pendaftar | enum('personal','instansi') | Jenis pendaftar, personal atau instansi |
| tanggal_daftar | date | Tanggal saat pendaftaran dilakukan |
| tanggal_kunjungan | date | Tanggal kunjungan yang dipilih |
| nama | varchar(255) NULL | Nama pendaftar (untuk personal) |
| nama_instansi | varchar(255) NULL | Nama instansi (untuk instansi) |
| alamat | text | Alamat pendaftar |
| email | varchar(255) | Email pendaftar |
| no_wa | varchar(20) NULL | Nomor WhatsApp pendaftar |
| tujuan_kunjungan | text | Tujuan melakukan kunjungan |
| surat_pengajuan | varchar(255) NULL | Path file surat pengajuan (untuk instansi) |
| jumlah_pengunjung | int(11) DEFAULT 1 | Jumlah pengunjung yang ikut |
| status_pengajuan | enum('pending','approved','rejected') DEFAULT 'pending' | Status pengajuan pendaftaran |
| catatan_admin | varchar(255) NULL | Catatan dari admin (alasan reject dll) |
| created_at | timestamp NULL | Timestamp dibuat |
| updated_at | timestamp NULL | Timestamp diupdate |

## 2. tabel_payment — Data Pembayaran

| Nama Kolom | Tipe Data | Keterangan |
|---|---|---|
| id_payment | bigint(20) AUTO_INCREMENT | Primary Key — ID unik payment |
| id_pendaftar | bigint(20) NOT NULL | Foreign Key → tabel_pendaftar.id_pendaftar |
| payment_method | enum('cash','qris') | Metode pembayaran |
| status | enum('pending','paid','failed') DEFAULT 'pending' | Status pembayaran |
| total | decimal(15,2) DEFAULT 0 | Total nominal pembayaran |
| created_at | timestamp NULL | Timestamp dibuat |
| updated_at | timestamp NULL | Timestamp diupdate |

## 3. tabel_kunjungan — Data Kunjungan (setelah pembayaran)

| Nama Kolom | Tipe Data | Keterangan |
|---|---|---|
| id_pengunjung | bigint(20) AUTO_INCREMENT | Primary Key — ID unik kunjungan |
| tanggal_daftar | date | Tanggal pendaftaran |
| tanggal_kunjungan | date | Tanggal kunjungan |
| nama | varchar(255) NULL | Nama pengunjung |
| nama_instansi | varchar(255) NULL | Nama instansi (jika ada) |
| email | varchar(255) | Email pengunjung |
| tujuan_kunjungan | text | Tujuan kunjungan |
| surat_pengajuan | varchar(255) NULL | File surat pengajuan |
| jumlah_pengunjung | int(11) DEFAULT 1 | Jumlah pengunjung |
| payment_method | varchar(255) | Metode pembayaran yang digunakan |
| id_payment | bigint(20) NOT NULL | Foreign Key → tabel_payment.id_payment |
| status_kunjungan | enum('waiting','completed') DEFAULT 'waiting' | Status kunjungan |
| qr_token | varchar(255) NOT NULL UNIQUE | Token unik untuk QR code check-in |
| created_at | timestamp NULL | Timestamp dibuat |
| updated_at | timestamp NULL | Timestamp diupdate |

## 4. tabel_disable_day — Hari Libur / Non-aktif

| Nama Kolom | Tipe Data | Keterangan |
|---|---|---|
| id_disday | bigint(20) AUTO_INCREMENT | Primary Key — ID unik disable day |
| tanggal | date NOT NULL UNIQUE | Tanggal yang dinonaktifkan |
| keterangan | varchar(255) NULL | Keterangan alasan penonaktifan |
| created_at | timestamp NULL | Timestamp dibuat |
| updated_at | timestamp NULL | Timestamp diupdate |

## 5. users — Data Admin / User Sistem

| Nama Kolom | Tipe Data | Keterangan |
|---|---|---|
| id | bigint(20) AUTO_INCREMENT | Primary Key — ID unik user |
| nama | varchar(255) | Nama lengkap user |
| email | varchar(255) UNIQUE | Email user (login) |
| email_verified_at | timestamp NULL | Tanggal verifikasi email |
| password | varchar(255) | Password ter-hash |
| role | varchar(255) DEFAULT 'admin' | Role / hak akses user |
| is_active | tinyint(1) DEFAULT 1 | Status aktif user |
| remember_token | varchar(100) NULL | Token untuk remember me |
| created_at | timestamp NULL | Timestamp dibuat |
| updated_at | timestamp NULL | Timestamp diupdate |

## 6. password_reset_tokens — Token Reset Password

| Nama Kolom | Tipe Data | Keterangan |
|---|---|---|
| email | varchar(255) NOT NULL | Primary Key — email user |
| token | varchar(255) | Token reset password |
| created_at | timestamp NULL | Timestamp dibuat |

## 7. sessions — Sesi Login User

| Nama Kolom | Tipe Data | Keterangan |
|---|---|---|
| id | varchar(255) NOT NULL | Primary Key — ID sesi |
| user_id | bigint(20) NULL INDEX | Foreign Key → users.id (ON DELETE SET NULL) |
| ip_address | varchar(45) NULL | Alamat IP user |
| user_agent | text NULL | Informasi browser/perangkat |
| payload | longtext | Data sesi (serialized) |
| last_activity | int(11) NOT NULL INDEX | Timestamp aktivitas terakhir |

---

**Relasi Antar Tabel:**
- `tabel_payment.id_pendaftar` → `tabel_pendaftar.id_pendaftar` (ON DELETE CASCADE)
- `tabel_kunjungan.id_payment` → `tabel_payment.id_payment` (ON DELETE CASCADE)
- `sessions.user_id` → `users.id` (ON DELETE SET NULL)
