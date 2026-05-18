@extends('layouts.app')

@php
    $pendaftar = $payment->pendaftar;
    $statusPengajuan = $pendaftar?->status_pengajuan;
@endphp

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-[#5C4033]">Status pengajuan & pembayaran</h1>
        <p class="mt-2 text-slate-600">
            Nomor pembayaran: <span class="font-mono font-semibold text-slate-800">#{{ $payment->id_payment }}</span>
        </p>
    </div>

    <div class="mb-6 grid gap-3 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-wrap justify-between gap-2 text-sm">
            <span class="text-slate-600">Metode</span>
            <span class="font-semibold uppercase text-slate-900">{{ str_replace('_', ' ', $payment->payment_method) }}</span>
        </div>
        <div class="flex flex-wrap justify-between gap-2 text-sm">
            <span class="text-slate-600">Status pembayaran</span>
            <span class="rounded-full px-2.5 py-0.5 text-xs font-bold uppercase tracking-wide {{ $payment->status === 'paid' ? 'bg-emerald-100 text-emerald-900' : 'bg-amber-100 text-amber-900' }}">
                {{ $payment->status === 'paid' ? 'Lunas' : 'Menunggu' }}
            </span>
        </div>
        <div class="flex flex-wrap justify-between gap-2 border-t border-slate-100 pt-3 text-sm">
            <span class="text-slate-600">Total</span>
            <span class="text-lg font-bold text-[#5C4033]">Rp {{ number_format($payment->total, 0, ',', '.') }}</span>
        </div>
        @if ($pendaftar)
            <div class="flex flex-wrap justify-between gap-2 border-t border-slate-100 pt-3 text-sm">
                <span class="text-slate-600">Status pengajuan (admin)</span>
                <span class="font-medium capitalize text-slate-900">{{ str_replace('_', ' ', $statusPengajuan ?? '-') }}</span>
            </div>
        @endif
    </div>

    <div class="mb-6 rounded-xl border border-slate-200 bg-slate-50/80 p-5 text-sm text-slate-700">
        <p class="font-semibold text-[#5C4033]">Alur sesuai pilihan Anda</p>
        <ul class="mt-2 list-disc space-y-1.5 pl-5">
            <li>
                <span class="font-medium">Cash:</span> pembayaran di lokasi / verifikasi admin sesuai kebijakan museum; setelah status lunas, kwitansi &amp; QR dapat dibuka.
            </li>
            <li>
                <span class="font-medium">Online:</span> dilanjutkan lewat <span class="font-medium">Midtrans</span> (e-wallet). Setelah pembayaran dikonfirmasi, unduh kwitansi + QR; Anda juga dapat meminta admin mengirim tagihan atau konfirmasi jika diperlukan.
            </li>
            <li>
                <span class="font-medium">Instansi:</span> pengajuan dapat <span class="font-medium">disetujui atau ditolak</span> oleh admin sebelum pembayaran final diproses.
            </li>
        </ul>
    </div>

    @if ($payment->status === 'paid' && $payment->kunjungan)
        <a
            href="{{ route('booking.receipt', $payment->id_payment) }}"
            class="inline-flex w-full items-center justify-center rounded-xl bg-[#5C4033] px-5 py-3.5 font-bold text-white shadow-md transition hover:bg-[#4a342a]"
        >
            Buka kwitansi &amp; QR
        </a>
        <p class="mt-3 text-center text-xs text-slate-500">Dari halaman kwitansi: kirim salinan ke email atau WhatsApp.</p>
    @elseif ($payment->status === 'paid' && ! $payment->kunjungan)
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-950">
            <p class="font-semibold">Pembayaran tercatat</p>
            <p class="mt-1">Kwitansi &amp; QR akan tersedia setelah data kunjungan dibuat. Silakan refresh atau hubungi admin bila menunggu lama.</p>
        </div>
    @elseif ($payment->payment_method === 'cash' && $payment->status !== 'paid')
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-950">
            <p class="font-semibold">Menunggu pembayaran tunai / konfirmasi</p>
            <p class="mt-1 text-amber-900/90">Silakan datang sesuai jadwal atau tunggu <span class="font-medium">request / instruksi pembayaran</span> dari admin jika diperlukan.</p>
        </div>
    @else
        <div class="mb-5 rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-950">
            <p class="font-semibold">Pembayaran online (Midtrans)</p>
            <p class="mt-1">Di lingkungan produksi, Anda akan diarahkan ke halaman/pembayaran Midtrans. Di sini tersedia tombol simulasi jika gateway belum diaktifkan.</p>
        </div>
        <form method="POST" action="{{ route('booking.payment.simulate', $payment->id_payment) }}" class="space-y-3">
            @csrf
            <button type="submit" class="w-full rounded-xl bg-sky-600 py-3.5 font-bold text-white shadow-md transition hover:bg-sky-700">
                Simulasikan pembayaran berhasil
            </button>
        </form>
    @endif

    <p class="mt-8 text-center text-xs text-slate-500">
        Kembali ke <a href="{{ route('home') }}" class="font-medium text-[#5C4033] underline">beranda</a>
        atau <a href="{{ route('booking.index') }}" class="font-medium text-[#5C4033] underline">form pengajuan</a>.
    </p>
</div>
@endsection
