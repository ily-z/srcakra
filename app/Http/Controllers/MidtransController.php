<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MidtransController extends Controller
{
    public function callback(Request $request): JsonResponse
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (! $orderId || ! $transactionStatus) {
            Log::warning('Midtrans callback received with missing fields', $payload);
            return response()->json(['message' => 'Missing required fields'], 400);
        }

        if ($transactionStatus !== 'capture' && $transactionStatus !== 'settlement') {
            return response()->json(['message' => 'Transaction not completed, ignoring']);
        }

        if ($fraudStatus === 'deny' || $fraudStatus === 'deny') {
            Log::warning("Midtrans transaction denied for order_id: {$orderId}");
            return response()->json(['message' => 'Transaction denied'], 403);
        }

        $payment = Payment::query()->where('midtrans_order_id', $orderId)->first();

        if (! $payment) {
            Log::warning("Payment not found for Midtrans order_id: {$orderId}");
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if ($payment->status === 'paid') {
            return response()->json(['message' => 'Already paid']);
        }

        DB::transaction(function () use ($payment) {
            $payment->update(['status' => 'paid']);
            $pendaftar = $payment->pendaftar;
            if ($pendaftar && $pendaftar->status_pengajuan !== 'approved') {
                $pendaftar->update(['status_pengajuan' => 'approved']);
            }
            if (! $payment->kunjungan) {
                Kunjungan::create([
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
            }
        });

        return response()->json(['message' => 'OK']);
    }
}
