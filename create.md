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
- online payment (biaya admin di bebankan pada pelanggan):
    - dana
    - gopay
    - shoppe
    - 

### Admin UI pages
login admin

navbar: 

- logo
- analitik
- pengajuan
- pembayaran
- history kunjungan
- Qr scanner
- 

page analitik: 

- chart kunjungan
- total pendapatan perbulan
- ‘kunjungan selesai’
- ‘kunjungan diajukan’

page pengajuan:

- list pengajuan(actions: approve, reject, view doc on instansi)
    - action add with detail, *example: **approve**: kunjungan bisa dilaksakan; **reject**: museum tutup*

page pembayaran:

- list pembayaran per kunjungan(pending, done)

page history kunjungan:

- kunjungan yg sudah selesai after qrscan(see details)

page Qr_scaner:

- scanner(open camera)

### UI user/customer/pengunjung

**main UI**

tabel kalender untuk melihat kunjungan dalam sebulan

Form:

*toggle dual form instansi dan personal*

- tanggal_kunjungan
- nama(none on instansi)
- nama instansi
- alamat
- email
- tujuan_kunjungan
- surat pengajuan(none on personal)
- jumlah pengunjung(none on personal) terhitung 1
- button pilihan metode pembayaran(online / cash)

button ‘mengajukan’

*approve / reject  dari admin*

request payment dari admin

kwitansi + QR code generate

jika pembayaran cash maka approve manual setelah menerima pembayaran cash di tempat

automatic send invoice & QR to email & wa

### email send 
- cash payment:
Subject:

Pengajuan Anda Telah Diterima – Museum Cakraningrat

Email Body:

Halo [Nama Customer],

Terima kasih, pengajuan Anda telah kami terima dengan detail sebagai berikut:

Informasi Pengajuan:

ID Pengajuan: [ID_PENGAJUAN]
Tanggal: [TANGGAL]
Jenis Layanan: [JENIS_LAYANAN]
Status: [status]

Saat ini pengajuan Anda sedang dalam proses verifikasi oleh tim kami.
Kami akan menginformasikan perkembangan selanjutnya melalui email ini.


Jika Anda memiliki pertanyaan, silakan hubungi kami melalui:

Email: [EMAIL_SUPPORT]
WhatsApp: [NO_WA]

Terima kasih atas kepercayaan Anda kepada kami.

Hormat kami,
Staff Museum Cakranigrat


- online payment:


Halo [Nama Customer],

Terima kasih, pengajuan Anda telah kami terima dengan detail sebagai berikut:

Informasi Pengajuan:

ID Pengajuan: [ID_PENGAJUAN]
Tanggal: [TANGGAL]
Jenis Layanan: [JENIS_LAYANAN]
Status: [status]

Saat ini pengajuan Anda sedang dalam proses verifikasi oleh tim kami.
Kami akan menginformasikan perkembangan selanjutnya melalui email ini.


Jika Anda memiliki pertanyaan, silakan hubungi kami melalui:

Email: [EMAIL_SUPPORT]
WhatsApp: [NO_WA]

Terima kasih atas kepercayaan Anda kepada kami.

Hormat kami,
Staff Museum Cakranigrat



## php mailer creadentials

Gmail: smtp.gmail.com
email address: joyboyboy11@gmail.com
app password: avay sjck folr qywh
email password: qiyasz52
SMTP secure: ssl
SSL: 465

### wa sender

api provider: fonnte.com
API token: tEaCWVAdP2BGSfQWfkqy
wa number: 6283168949600