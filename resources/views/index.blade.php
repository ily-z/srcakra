@extends('layouts.app')

@push('background')
    @include('partials.bubble-background')
@endpush

@section('content')
<style>
    @keyframes home-btn-glow {
        0%, 100% { box-shadow: 0 4px 14px rgba(92, 64, 51, 0.25); }
        50% { box-shadow: 0 4px 24px rgba(92, 64, 51, 0.45); }
    }
    .btn-home-cta {
        animation: home-btn-glow 2.5s ease-in-out infinite;
    }
    .btn-home-cta:hover {
        animation: none;
    }
</style>

<div class="animate-in fade-in slide-in-from-bottom duration-700 py-8 text-center">
    <h1 class="mb-3 text-4xl font-bold text-[#5C4033]">
        Museum Cakraningrat
    </h1>
    <p class="mb-8 text-lg text-slate-700">
        Jelajahi sejarah dan budaya Bangkalan
    </p>

    <a
        href="{{ route('booking.index') }}"
        class="group inline-flex items-center justify-center gap-2 rounded-lg bg-[#5C4033] px-8 py-3 font-semibold text-white shadow-md transition-all duration-300 hover:bg-[#4a342a] hover:shadow-lg hover:scale-105 active:scale-95 btn-home-cta"
    >
        <span>Ajukan kunjungan</span>
        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
    </a>
    <p class="mt-3 text-sm text-slate-600">Langsung ke form pendaftaran</p>
</div>

<div class="animate-in fade-in slide-in-from-bottom duration-700 delay-150 mb-8">
    @include('partials.visitor_calendar', ['calendarInteractive' => false])
</div>

<div class="animate-in fade-in slide-in-from-bottom duration-700 delay-300 mb-8 rounded-xl bg-amber-50/80 p-5 text-left shadow-md ring-1 ring-amber-200/60">
    <h2 class="mb-2 text-lg font-semibold text-[#5C4033]">Alur pengunjung</h2>
    <ol class="list-decimal space-y-2 pl-5 text-sm text-slate-700">
        <li>Isi form (personal atau instansi) dan pilih <span class="font-medium">Cash</span> atau <span class="font-medium">pembayaran online</span> (Midtrans / e-wallet).</li>
        <li>Untuk instansi, pengajuan dapat <span class="font-medium">disetujui atau ditolak</span> oleh admin; jika disetujui, lanjut ke instruksi pembayaran.</li>
        <li>Setelah pembayaran diverifikasi, unduh <span class="font-medium">kwitansi + QR</span> dan dapat dikirim ke email atau WhatsApp.</li>
    </ol>
</div>

<div class="animate-in fade-in slide-in-from-bottom duration-700 delay-500 mb-8 rounded-xl bg-white p-6 shadow-md">
    <h2 class="mb-3 text-2xl font-semibold text-[#5C4033]">
        Tentang Museum
    </h2>
    <p class="text-slate-700">
        Museum Cakraningrat menyimpan berbagai koleksi bersejarah
        yang menggambarkan perjalanan budaya dan sejarah Bangkalan.
    </p>
</div>

<div class="animate-in fade-in slide-in-from-bottom duration-700 delay-[650ms] grid gap-6 md:grid-cols-2">
    <div class="rounded-xl bg-white p-6 shadow-md">
        <h3 class="mb-2 text-xl font-semibold">Jam Operasional</h3>
        <p class="text-slate-700">Senin - Jumat: 08:00 - 16:00</p>
        <p class="text-slate-700">Sabtu - Minggu: 09:00 - 17:00</p>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-md">
        <h3 class="mb-2 text-xl font-semibold">Harga Tiket (referensi)</h3>
        <p class="text-slate-700">Dewasa: Rp10.000</p>
        <p class="text-slate-700">Anak-anak: Rp5.000</p>
        <p class="mt-2 text-xs text-slate-500">Total di halaman pembayaran mengikuti jumlah pengunjung.</p>
    </div>
</div>
@endsection
