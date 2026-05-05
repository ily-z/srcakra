##tech stack
 - tailwind
 - react
 - laravel
 - mysql

### DB

- tabel_pendaftar_kunjungan(dua jenis, personal & instansi(bulk))
    - id_pendaftar
    - tangal_daftar
    - tanggal_kunjungan
    - nama(none on instansi)
    - nama instansi
    - alamat
    - email
    - tujuan_kunjungan
    - surat pengajuan(none on personal)
    - jumlah pengunjung(none on personal) terhitung 1
    - id_payment FK
- tabel_payment
    - id_payment
    - id_pendaftar FK
    - payment method
    - status
    - total
- tabel_kunjungan (done payment)
    - id_pengunjung
    - tanggal_daftar
    - tanggal_kunjungan
    - nama(none on instansi)
    - nama_instansi
    - email
    - tujuan_kunjungan
    - surat_pengajuan
    - jumlah_pengunjung(none on personal)
    - paymet method
    - id_payment
    - status_kunjungan
    - qr_token
- tabel_disable_day
    - id_disday
    - tanggal
    - keterangan

---

### on payment method

- cash
- online payment:
    - dana
    - gopay
    - shoppe
    - 

### Admin UI pages

navbar: 

- logo
- analitik
- pengajuan
- pembayaran
- history kunjungan
- Qr scanner
- 

analitik: 

- chart kunjungan
- total pendapatan perbulan
- ‘kunjungan selesai’
- ‘kunjungan diajukan’

pangajuan:

- list pengajuan(actions: approve, reject, view doc on instansi)
    - action add with detail, *example: **approve**: kunjungan bisa dilaksakan; **reject**: museum tutup*

pembayaran:

- list pembayaran per kunjungan(pending, done)

history kunjungan:

- kunjungan yg sudah selesai after qrscan(see details)

Qr_scaner:

- scanner(open camera)

### UI user/customer/pengunjung

*direct to form*

Form:

- tanggal_kunjungan
- nama(none on instansi)
- nama instansi
- alamat
- email
- tujuan_kunjungan
- surat pengajuan(none on personal)
- jumlah pengunjung(none on personal) terhitung 1

Next → approve(pembayararan cash approve sendiri)

        → di tolak

online payment gateway(midtrans)

kwitansi + QR code generate

send invoice & QR to email & wa