@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.history') }}" class="text-sm text-blue-600 underline">&larr; Kembali ke History</a>
</div>

<h1 class="mb-6 text-2xl font-bold">Detail Kunjungan</h1>

<div class="rounded-lg bg-white p-4 shadow md:p-6">
    <dl class="divide-y text-sm">
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">Nama / Instansi</dt>
            <dd>{{ $kunjungan->nama ?: $kunjungan->nama_instansi ?: '-' }}</dd>
        </div>
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">Email</dt>
            <dd class="break-all">{{ $kunjungan->email }}</dd>
        </div>
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">Tanggal Daftar</dt>
            <dd>{{ $kunjungan->tanggal_daftar }}</dd>
        </div>
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">Tanggal Kunjungan</dt>
            <dd>{{ $kunjungan->tanggal_kunjungan }}</dd>
        </div>
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">Tujuan Kunjungan</dt>
            <dd>{{ $kunjungan->tujuan_kunjungan }}</dd>
        </div>
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">Jumlah Pengunjung</dt>
            <dd>{{ $kunjungan->jumlah_pengunjung }}</dd>
        </div>
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">Metode Pembayaran</dt>
            <dd class="uppercase">{{ $kunjungan->payment_method }}</dd>
        </div>
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">Status Kunjungan</dt>
            <dd>
                <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-bold uppercase text-emerald-800">
                    {{ $kunjungan->status_kunjungan }}
                </span>
            </dd>
        </div>
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">QR Token</dt>
            <dd class="break-all font-mono text-xs">{{ $kunjungan->qr_token }}</dd>
        </div>
        @if($kunjungan->surat_pengajuan)
        <div class="flex flex-col gap-1 px-3 py-3 md:flex-row md:px-0">
            <dt class="font-semibold text-slate-600 md:w-48">Surat Pengajuan</dt>
            <dd>
                <a class="text-blue-600 underline" target="_blank" href="{{ asset('storage/'.$kunjungan->surat_pengajuan) }}">Lihat Dokumen</a>
            </dd>
        </div>
        @endif
    </dl>
</div>
@endsection
