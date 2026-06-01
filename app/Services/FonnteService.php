<?php

namespace App\Services;

use App\Models\Kunjungan;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class FonnteService
{
    public static function sendPengajuan(Payment $payment, ?string $paymentUrl = null): void
    {
        $pendaftar = $payment->pendaftar;
        $name = $pendaftar->nama ?: $pendaftar->nama_instansi ?: 'Pengunjung';
        $tanggal = Carbon::parse($pendaftar->tanggal_daftar)->locale('id')->translatedFormat('d F Y');
        $waNumber = config('services.fonnte.number', '6283168949600');

        $message = "Halo {$name},\n\n";
        $message .= "Pengajuan kunjungan Anda ke Museum Cakraningrat telah disetujui.\n\n";
        $message .= "Informasi Pengajuan:\n\n";
        $message .= "ID Pengajuan: {$pendaftar->id_pendaftar}\n";
        $message .= "Tanggal: {$tanggal}\n";
        $message .= "Jenis Layanan: " . ucfirst($pendaftar->jenis_pendaftar) . "\n";
        $message .= "Status: Disetujui\n";
        $message .= "Metode Pembayaran: " . strtoupper($payment->payment_method) . "\n\n";

        if ($paymentUrl) {
            $message .= "Silakan lakukan pembayaran secara online pada tautan berikut:\n{$paymentUrl}\n\n";
        } elseif ($payment->payment_method !== 'cash') {
            $message .= "Untuk metode pembayaran online, Anda akan menerima pesan lanjutan dengan instruksi pembayaran.\n\n";
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

    public static function sendMessage(string $target, string $message): void
    {
        Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
        ]);
    }

    public static function sendInvoice(Kunjungan $kunjungan): void
    {
        $pendaftar = $kunjungan->payment->pendaftar;
        $name = $kunjungan->nama ?: $kunjungan->nama_instansi ?: 'Pengunjung';
        $receiptUrl = route('booking.receipt', $kunjungan->id_payment);

        $message = "Halo {$name},\n\n";
        $message .= "Pembayaran Anda telah dikonfirmasi. Berikut adalah invoice dan QR code untuk kunjungan Anda:\n\n";
        $message .= "{$receiptUrl}\n\n";
        $message .= "Tunjukkan QR code pada saat check-in di museum.\n\n";
        $message .= "Terima kasih.\n";
        $message .= "Staff Museum Cakraningrat";

        Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $pendaftar->no_wa,
            'message' => $message,
        ]);
    }
}
