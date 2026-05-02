<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    // KunjunganController.php

public function store(Request $request) {
    // 1. Simpan ke Tabel Pendaftar
    $pendaftar = Pendaftar::create([
        'jenis_pendaftar' => $request->jenis,
        'tanggal_daftar' => now(),
        'tanggal_kunjungan' => $request->tanggal_kunjungan,
        'nama' => $request->nama,
        'nama_instansi' => $request->nama_instansi,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'tujuan_kunjungan' => $request->tujuan,
        'jumlah_pengunjung' => $request->jenis == 'personal' ? 1 : $request->jumlah_pengunjung,
    ]);

    // 2. Buat Record Payment
    $payment = Payment::create([
        'id_pendaftar' => $pendaftar->id_pendaftar,
        'payment_method' => $request->method,
        'total' => $this->hitungTotal($request), // Logika harga Anda
        'status' => $request->method == 'cash' ? 'success' : 'pending',
    ]);

    // 3. ALUR LOGIKA
    if ($request->method == 'cash') {
        // Jika Cash, langsung pindahkan ke tabel_kunjungan
        $this->moveToKunjungan($pendaftar, $payment);
        return redirect()->route('receipt', $payment->id_payment);
    } else {
        // Jika Midtrans, generate Snap Token
        $snapToken = $this->generateMidtransToken($payment, $pendaftar);
        $payment->update(['snap_token' => $snapToken]);
        return response()->json(['snap_token' => $snapToken]);
    }
}

private function moveToKunjungan($pendaftar, $payment) {
    return Kunjungan::create([
        'tanggal_kunjungan' => $pendaftar->tanggal_kunjungan,
        'nama_display' => $pendaftar->nama ?? $pendaftar->nama_instansi,
        'email' => $pendaftar->email,
        'jumlah_pengunjung' => $pendaftar->jumlah_pengunjung,
        'payment_method' => $payment->payment_method,
        'id_payment' => $payment->id_payment,
        'qr_token' => bin2hex(random_bytes(16)), // Generate random token
    ]);
}

    public function create()
    {
        $slots = Slot::all();

        return view('booking.index', compact('slots'));
    }
}
