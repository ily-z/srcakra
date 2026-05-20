<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class FonnteService
{
    public static function sendPengajuan(Payment $payment): void
    {
        $pendaftar = $payment->pendaftar;
        $name = $pendaftar->nama ?: $pendaftar->nama_instansi ?: 'Pengunjung';
        $tanggal = Carbon::parse($pendaftar->tanggal_daftar)->locale('id')->translatedFormat('d F Y');
        $waNumber = config('services.fonnte.number', '6283168949600');

        $message = "Halo {$name},\n\n";
        $message .= "Terima kasih, pengajuan Anda telah kami terima dengan detail sebagai berikut:\n\n";
        $message .= "Informasi Pengajuan:\n\n";
        $message .= "ID Pengajuan: {$pendaftar->id_pendaftar}\n";
        $message .= "Tanggal: {$tanggal}\n";
        $message .= "Jenis Layanan: " . ucfirst($pendaftar->jenis_pendaftar) . "\n";
        $message .= "Status: Menunggu Verifikasi\n";
        $message .= "Metode Pembayaran: " . strtoupper($payment->payment_method) . "\n\n";
        $message .= "Saat ini pengajuan Anda sedang dalam proses verifikasi oleh tim kami.\n";
        $message .= "Kami akan menginformasikan perkembangan selanjutnya melalui WhatsApp ini.\n\n";

        if ($payment->payment_method !== 'cash') {
            $message .= "Untuk metode pembayaran online, Anda akan menerima pesan lanjutan dengan instruksi pembayaran setelah pengajuan Anda disetujui oleh admin.\n\n";
        }

        $message .= "Jika Anda memiliki pertanyaan, silakan hubungi kami melalui:\n";
        $message .= "Email: joyboyboy11@gmail.com\n";
        $message .= "WhatsApp: {$waNumber}\n\n";
        $message .= "Terima kasih atas kepercayaan Anda kepada kami.\n\n";
        $message .= "Hormat kami,\nStaff Museum Cakraningrat";

        Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $pendaftar->no_wa,
            'message' => $message,
        ]);
    }
}
