@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="mb-6 text-center">
        <p class="text-xs font-semibold uppercase tracking-widest text-[#5C4033]/80">Museum Cakraningrat</p>
        <h1 class="mt-1 text-3xl font-bold text-[#5C4033]">Kwitansi &amp; tiket masuk</h1>
        <p class="mt-2 text-sm text-slate-600">Tunjukkan QR di pintu masuk. Simpan atau kirim salinan ke email / WhatsApp.</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg">
        <div class="border-b border-slate-100 bg-[#5C4033]/5 px-6 py-4">
            <div class="flex flex-wrap items-baseline justify-between gap-2">
                <span class="text-sm text-slate-600">No. pembayaran</span>
                <span class="font-mono text-lg font-bold text-slate-900">#{{ $payment->id_payment }}</span>
            </div>
        </div>
        <div class="space-y-3 px-6 py-5 text-sm">
            <div class="flex justify-between gap-2 border-b border-dashed border-slate-200 pb-2">
                <span class="text-slate-600">Nama / instansi</span>
                <span class="max-w-[60%] text-right font-semibold text-slate-900">{{ $kunjungan->nama ?: $kunjungan->nama_instansi }}</span>
            </div>
            <div class="flex justify-between gap-2 border-b border-dashed border-slate-200 pb-2">
                <span class="text-slate-600">Email</span>
                <span class="text-right text-slate-800">{{ $kunjungan->email }}</span>
            </div>
            <div class="flex justify-between gap-2 border-b border-dashed border-slate-200 pb-2">
                <span class="text-slate-600">Tanggal kunjungan</span>
                <span class="font-medium text-slate-900">{{ \Illuminate\Support\Carbon::parse($kunjungan->tanggal_kunjungan)->locale('id')->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="flex justify-between gap-2 border-b border-dashed border-slate-200 pb-2">
                <span class="text-slate-600">Jumlah pengunjung</span>
                <span class="font-medium text-slate-900">{{ $kunjungan->jumlah_pengunjung }}</span>
            </div>
            <div class="flex justify-between gap-2 border-b border-dashed border-slate-200 pb-2">
                <span class="text-slate-600">Metode pembayaran</span>
                <span class="uppercase text-slate-800">{{ $payment->payment_method }}</span>
            </div>
            <div class="flex justify-between gap-2 pt-1">
                <span class="text-base font-semibold text-slate-800">Total</span>
                <span class="text-xl font-bold text-[#5C4033]">Rp {{ number_format($payment->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="border-t border-slate-100 bg-slate-50/80 px-6 py-6 text-center">
            <p class="mb-3 text-xs font-medium uppercase tracking-wide text-slate-500">QR check-in</p>
            <img
                class="mx-auto rounded-xl border border-white bg-white p-3 shadow-sm"
                alt="QR kunjungan"
                width="220"
                height="220"
                src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($kunjungan->qr_token) }}"
            />
            <p class="mt-3 break-all text-[10px] text-slate-400">Token: {{ $kunjungan->qr_token }}</p>
        </div>
    </div>

    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="mb-3 text-center text-sm font-semibold text-slate-800">Kirim kwitansi &amp; QR</p>
        <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a
                class="inline-flex flex-1 items-center justify-center rounded-xl bg-emerald-600 px-4 py-3 text-center text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700"
                href="mailto:{{ $kunjungan->email }}?subject={{ rawurlencode('Kwitansi kunjungan Museum Cakraningrat') }}&body={{ rawurlencode('Link kwitansi & QR: ' . route('booking.receipt', $payment->id_payment)) }}"
            >
                Kirim ke email
            </a>
            <a
                class="inline-flex flex-1 items-center justify-center rounded-xl bg-[#25D366] px-4 py-3 text-center text-sm font-bold text-white shadow-sm transition hover:bg-[#20bd5a]"
                href="https://wa.me/?text={{ rawurlencode('Kwitansi & QR kunjungan Museum: ' . route('booking.receipt', $payment->id_payment)) }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Kirim ke WhatsApp
            </a>
        </div>
        <p class="mt-3 text-center text-xs text-slate-500">WhatsApp membuka aplikasi dengan pesan berisi link halaman ini.</p>
    </div>

    <p class="mt-8 text-center text-xs text-slate-500">
        <a href="{{ route('home') }}" class="font-medium text-[#5C4033] underline">Beranda</a>
        ·
        <a href="{{ route('booking.index') }}" class="font-medium text-[#5C4033] underline">Form baru</a>
    </p>
</div>
@endsection
