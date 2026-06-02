<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Ditolak</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f4f4;font-family:Arial,sans-serif">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;padding:20px">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden">
                    <tr>
                        <td style="background-color:#991b1b;padding:30px;text-align:center">
                            <h1 style="color:#ffffff;margin:0;font-size:24px">Pengajuan Ditolak</h1>
                            <p style="color:#fca5a5;margin:8px 0 0">Museum Cakraningrat</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px">
                            <p style="font-size:16px;color:#333">Halo <strong>{{ $pendaftar->nama ?: $pendaftar->nama_instansi }}</strong>,</p>
                            <p style="font-size:14px;color:#555;line-height:1.6">
                                Mohon maaf, pengajuan kunjungan Anda ke Museum Cakraningrat <strong>ditolak</strong>.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0;background-color:#fef2f2;border-radius:6px;padding:20px">
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888;width:140px">ID Pengajuan</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: {{ $pendaftar->id_pendaftar }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888">Tanggal</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: {{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->locale('id')->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888">Jenis Layanan</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: {{ ucfirst($pendaftar->jenis_pendaftar) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888">Status</td>
                                    <td style="padding:6px 0;font-size:14px;color:#991b1b">: <strong>Ditolak</strong></td>
                                </tr>
                                @if ($pendaftar->catatan_admin)
                                <tr>
                                    <td style="padding:6px 0;font-size:14px;color:#888">Alasan</td>
                                    <td style="padding:6px 0;font-size:14px;color:#333">: {{ $pendaftar->catatan_admin }}</td>
                                </tr>
                                @endif
                            </table>

                            <p style="font-size:14px;color:#555;line-height:1.6">
                                Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami melalui kontak di bawah.
                            </p>

                            <hr style="border:none;border-top:1px solid #e0d6cc;margin:24px 0">

                            <p style="font-size:13px;color:#888;line-height:1.6;margin:0">
                                Jika Anda memiliki pertanyaan, silakan hubungi kami melalui:
                            </p>
                            <p style="font-size:13px;color:#888;line-height:1.6;margin:4px 0 0">
                                Email: joyboyboy11@gmail.com<br>
                                WhatsApp: 6283168949600
                            </p>

                            <p style="font-size:13px;color:#888;line-height:1.6;margin-top:20px">
                                Terima kasih.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#991b1b;padding:15px;text-align:center">
                            <p style="color:#fca5a5;margin:0;font-size:12px">Hormat kami, Staff Museum Cakraningrat</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
