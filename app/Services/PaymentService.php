<?php

namespace App\Services;

use App\Models\Kunjungan;
use App\Models\Payment;
use App\Services\FonnteService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Mark a payment as paid, create kunjungan record if needed, and send notifications.
     */
    public function completePayment(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            if ($payment->status !== 'paid') {
                $payment->update(['status' => 'paid']);
            }

            $pendaftar = $payment->pendaftar;
            if ($pendaftar) {
                if ($pendaftar->status_pengajuan !== 'approved') {
                    $pendaftar->update(['status_pengajuan' => 'approved']);
                }

                if (! $payment->kunjungan) {
                    $kunjungan = Kunjungan::create([
                        'tanggal_daftar' => $pendaftar->tanggal_daftar,
                        'tanggal_kunjungan' => $pendaftar->tanggal_kunjungan,
                        'nama' => $pendaftar->nama,
                        'nama_instansi' => $pendaftar->nama_instansi,
                        'email' => $pendaftar->email,
                        'tujuan_kunjungan' => $pendaftar->tujuan_kunjungan,
                        'surat_pengajuan' => $pendaftar->surat_pengajuan,
                        'jumlah_pengunjung' => $pendaftar->jumlah_pengunjung,
                        'payment_method' => $payment->payment_method,
                        'id_payment' => $payment->id_payment,
                        'status_kunjungan' => 'waiting',
                        'qr_token' => (string) Str::uuid(),
                    ]);

                    $this->sendNotifications($kunjungan);
                }
            }
        });
    }

    /**
     * Send email and WhatsApp notifications for the kunjungan.
     */
    public function sendNotifications(Kunjungan $kunjungan): void
    {
        // Email Notification
        try {
            $name = $kunjungan->nama ?: $kunjungan->nama_instansi ?: 'Pengunjung';
            $receiptUrl = route('booking.receipt', $kunjungan->id_payment);
            Mail::raw("Halo {$name}, invoice dan QR kunjungan Anda: {$receiptUrl}", function ($message) use ($kunjungan) {
                $message->to($kunjungan->email)->subject('Invoice & QR Kunjungan Museum');
            });
        } catch (\Throwable) {
            // Keep non-blocking when mail server is unavailable.
        }

        // WhatsApp Notification
        try {
            FonnteService::sendInvoice($kunjungan);
        } catch (\Throwable) {
            // Keep non-blocking when WhatsApp server is unavailable.
        }
    }
}
