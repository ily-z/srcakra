<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice & QR Kunjungan</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,sans-serif">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;padding:20px">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden">
                    <tr>
                        <td style="background-color:#5C4033;padding:30px;text-align:center">
                            <h1 style="color:#ffffff;margin:0;font-size:24px">Pembayaran Dikonfirmasi</h1>
                            <p style="color:#d4c5b5;margin:8px 0 0">Museum Cakraningrat</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px">
                            <p style="font-size:16px;color:#333">Halo <strong>{{ $kunjungan->nama ?: $kunjungan->nama_instansi }}</strong>,</p>
                            <p style="font-size:14px;color:#555;line-height:1.6">
                                Pembayaran Anda telah dikonfirmasi. Berikut adalah detail kunjungan dan QR code untuk check-in.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0;background-color:#f9f7f5;border-radius:6px;padding:20px">
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888;width:140px">No. Pembayaran</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: #{{ $kunjungan->id_payment }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888">Nama / Instansi</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: {{ $kunjungan->nama ?: $kunjungan->nama_instansi }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888">Tanggal Kunjungan</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->locale('id')->translatedFormat('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888">Jumlah Pengunjung</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: {{ $kunjungan->jumlah_pengunjung }} orang</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888">Metode Pembayaran</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: {{ strtoupper($kunjungan->payment_method) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888">Total</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: <strong>Rp {{ number_format($kunjungan->payment->total, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>

                            <p style="font-size:14px;color:#555;line-height:1.6">
                                Silakan klik tombol di bawah untuk melihat invoice dan QR code lengkap:
                            </p>
                            <p style="margin:16px 0;text-align:center">
                                <a href="{{ route('booking.receipt', $kunjungan->id_payment) }}" style="display:inline-block;background-color:#5C4033;color:#ffffff;padding:12px 28px;border-radius:6px;font-size:14px;font-weight:bold;text-decoration:none">
                                    Lihat Invoice & QR
                                </a>
                            </p>
                            <p style="font-size:12px;color:#888;line-height:1.6">
                                Atau salin tautan berikut ke browser:<br>
                                {{ route('booking.receipt', $kunjungan->id_payment) }}
                            </p>

                            <hr style="border:none;border-top:1px solid #e0d6cc;margin:24px 0">

                            <p style="font-size:13px;color:#888;line-height:1.6;margin:0">
                                Tunjukkan QR code pada saat check-in di museum.
                            </p>
                            <p style="font-size:13px;color:#888;line-height:1.6;margin:4px 0 0">
                                Jika Anda memiliki pertanyaan, silakan hubungi kami melalui:<br>
                                Email: joyboyboy11@gmail.com
                            </p>

                            <p style="font-size:13px;color:#888;line-height:1.6;margin-top:20px">
                                Terima kasih atas kunjungan Anda.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#5C4033;padding:15px;text-align:center">
                            <p style="color:#d4c5b5;margin:0;font-size:12px">Hormat kami, Staff Museum Cakraningrat</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
