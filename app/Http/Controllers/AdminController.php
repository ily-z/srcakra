<?php

namespace App\Http\Controllers;

use App\Mail\PengajuanDiterima;
use App\Models\Kunjungan;
use App\Models\Payment;
use App\Models\Pendaftar;
use App\Services\FonnteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function analytics(): View
    {
        $monthlyRevenue = Payment::query()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total) as total')
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $visitChart = Kunjungan::query()
            ->selectRaw('tanggal_kunjungan, COUNT(*) as total_kunjungan')
            ->groupBy('tanggal_kunjungan')
            ->orderBy('tanggal_kunjungan')
            ->get();

        return view('admin.analytics', [
            'labelsRevenue' => $monthlyRevenue->keys()->values(),
            'valuesRevenue' => $monthlyRevenue->values(),
            'labelsVisit' => $visitChart->pluck('tanggal_kunjungan')->map(fn ($d) => Carbon::parse($d)->format('Y-m-d'))->values(),
            'valuesVisit' => $visitChart->pluck('total_kunjungan')->values(),
            'kunjunganSelesai' => Kunjungan::query()->where('status_kunjungan', 'completed')->count(),
            'kunjunganDiajukan' => Pendaftar::query()->where('status_pengajuan', 'pending')->count(),
        ]);
    }

    public function pengajuan(): View
    {
        $pengajuan = Pendaftar::query()->with('payment')->latest('id_pendaftar')->paginate(15);
        return view('admin.pengajuan', compact('pengajuan'));
    }

    public function approve(Pendaftar $pendaftar, Request $request): RedirectResponse
    {
        $request->validate(['catatan_admin' => ['nullable', 'string', 'max:255']]);

        $pendaftar->update([
            'status_pengajuan' => 'approved',
            'catatan_admin' => $request->input('catatan_admin'),
        ]);

        $payment = $pendaftar->payment;

        if ($payment) {
            try {
                Mail::to($pendaftar->email)->send(new PengajuanDiterima($payment));
            } catch (\Throwable) {
                // Keep non-blocking when mail server is unavailable.
            }

            if ($pendaftar->no_wa) {
                try {
                    FonnteService::sendPengajuan($payment);
                } catch (\Throwable) {
                    // Keep non-blocking when WhatsApp server is unavailable.
                }
            }
        }

        return back()->with('success', 'Pengajuan disetujui.');
    }

    public function reject(Pendaftar $pendaftar, Request $request): RedirectResponse
    {
        $request->validate(['catatan_admin' => ['required', 'string', 'max:255']]);

        $pendaftar->update([
            'status_pengajuan' => 'rejected',
            'catatan_admin' => $request->input('catatan_admin'),
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }

    public function pembayaran(): View
    {
        $payments = Payment::query()->with('pendaftar')->latest('id_payment')->paginate(15);
        return view('admin.pembayaran', compact('payments'));
    }

    public function markPaid(Payment $payment): RedirectResponse
    {
        DB::transaction(function () use ($payment) {
            if ($payment->status !== 'paid') {
                $payment->update(['status' => 'paid']);
            }

            if ($payment->pendaftar) {
                if ($payment->pendaftar->status_pengajuan !== 'approved') {
                    $payment->pendaftar->update(['status_pengajuan' => 'approved']);
                }

                if (! $payment->kunjungan) {
                    $kunjungan = Kunjungan::create([
                        'tanggal_daftar' => $payment->pendaftar->tanggal_daftar,
                        'tanggal_kunjungan' => $payment->pendaftar->tanggal_kunjungan,
                        'nama' => $payment->pendaftar->nama,
                        'nama_instansi' => $payment->pendaftar->nama_instansi,
                        'email' => $payment->pendaftar->email,
                        'tujuan_kunjungan' => $payment->pendaftar->tujuan_kunjungan,
                        'surat_pengajuan' => $payment->pendaftar->surat_pengajuan,
                        'jumlah_pengunjung' => $payment->pendaftar->jumlah_pengunjung,
                        'payment_method' => $payment->payment_method,
                        'id_payment' => $payment->id_payment,
                        'status_kunjungan' => 'waiting',
                        'qr_token' => (string) Str::uuid(),
                    ]);

                    $this->sendInvoiceEmail($kunjungan);
                }
            }
        });

        return back()->with('success', 'Status pembayaran diubah menjadi paid.');
    }

    private function sendInvoiceEmail(Kunjungan $kunjungan): void
    {
        try {
            $name = $kunjungan->nama ?: $kunjungan->nama_instansi ?: 'Pengunjung';
            $receiptUrl = route('booking.receipt', $kunjungan->id_payment);
            Mail::raw("Halo {$name}, invoice dan QR kunjungan Anda: {$receiptUrl}", function ($message) use ($kunjungan) {
                $message->to($kunjungan->email)->subject('Invoice & QR Kunjungan Museum');
            });
        } catch (\Throwable) {
            // Keep non-blocking when mail server is unavailable.
        }

        try {
            FonnteService::sendInvoice($kunjungan);
        } catch (\Throwable) {
            // Keep non-blocking when WhatsApp server is unavailable.
        }
    }

    public function requestPayment(Payment $payment): RedirectResponse
    {
        $pendaftar = $payment->pendaftar;

        if ($payment->status === 'paid') {
            return back()->with('error', 'Pembayaran sudah lunas.');
        }

        if (! $pendaftar || $pendaftar->status_pengajuan !== 'approved') {
            return back()->with('error', 'Pengajuan harus disetujui terlebih dahulu sebelum request payment.');
        }

        $name = $pendaftar->nama ?: $pendaftar->nama_instansi ?: 'Pengunjung';
        $paymentUrl = route('booking.payment', $payment->id_payment);

        try {
            Mail::raw(
                "Halo {$name},\n\nPengajuan kunjungan Anda telah disetujui.\n\nSilakan lakukan pembayaran melalui link berikut:\n{$paymentUrl}\n\nSetelah pembayaran dikonfirmasi, Anda akan menerima invoice dan QR code untuk check-in.\n\nTerima kasih.",
                function ($message) use ($pendaftar, $name) {
                    $message->to($pendaftar->email)
                        ->subject('Permintaan Pembayaran Kunjungan Museum Cakraningrat');
                }
            );
        } catch (\Throwable) {
            return back()->with('warning', 'Gagal mengirim email. Namun payment request tetap tercatat.');
        }

        return back()->with('success', 'Permintaan pembayaran dikirim ke email pengunjung.');
    }

    public function history(): View
    {
        $kunjungan = Kunjungan::query()
            ->where('status_kunjungan', 'completed')
            ->latest('updated_at')
            ->paginate(15);
        return view('admin.history', compact('kunjungan'));
    }

    public function historyDetail(Kunjungan $kunjungan): View
    {
        return view('admin.history-detail', compact('kunjungan'));
    }

    public function scanner(): View
    {
        return view('admin.scanner');
    }

    public function scanToken(string $token): RedirectResponse
    {
        $kunjungan = Kunjungan::query()->where('qr_token', $token)->first();
        if (! $kunjungan) {
            return back()->with('error', 'QR tidak valid.');
        }

        $kunjungan->update(['status_kunjungan' => 'completed']);
        return back()->with('success', 'QR valid. Kunjungan ditandai selesai.');
    }
}
