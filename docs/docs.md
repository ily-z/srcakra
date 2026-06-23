1. Proses Pendaftaran Kunjungan
- Swimlanes: Visitor, System, Admin
- Start: Visitor membuka form booking
- End: Redirect ke halaman status pembayaran
- Decision: personal vs instansi, tanggal disabled?, upload surat?
2. Proses Approve / Reject Pendaftaran
- Swimlanes: Admin, System
- Start: Admin buka daftar pengajuan
- End: Redirect ke daftar pengajuan
- Decision: approve vs reject, kirim notif WA? email?
3. Proses Pembayaran & Konfirmasi
- Swimlanes: Admin, System, (Visitor)
- Start: Admin klik "Mark as Paid"
- End: Kunjungan dibuat, invoice terkirim
- Decision: payment sudah paid?, sudah ada kunjungan?, auto-approve pendaftar
4. Proses Scan QR Check-in
- Swimlanes: Admin, System
- Start: Admin buka scanner page
- End: Kunjungan marked completed
- Decision: token valid?, sudah completed sebelumnya?
5. Alur Lengkap Pengunjung (End-to-End)
- Swimlanes: Visitor, System, Admin
- Start: Visitor buka website
- End: Kunjungan selesai
- Mencakup: booking → approval → payment → check-in (gabungan dari 4 diagram di atas)