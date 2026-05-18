@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.history') }}" class="text-sm text-blue-600 underline">&larr; Kembali ke History</a>
</div>

<h1 class="mb-6 text-2xl font-bold">Detail Kunjungan</h1>

<div class="rounded-lg bg-white p-6 shadow">
    <table class="w-full text-sm">
        <tbody>
            <tr class="border-b">
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">Nama / Instansi</td>
                <td class="px-3 py-2">{{ $kunjungan->nama ?: $kunjungan->nama_instansi ?: '-' }}</td>
            </tr>
            <tr class="border-b">
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">Email</td>
                <td class="px-3 py-2">{{ $kunjungan->email }}</td>
            </tr>
            <tr class="border-b">
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">Tanggal Daftar</td>
                <td class="px-3 py-2">{{ $kunjungan->tanggal_daftar }}</td>
            </tr>
            <tr class="border-b">
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">Tanggal Kunjungan</td>
                <td class="px-3 py-2">{{ $kunjungan->tanggal_kunjungan }}</td>
            </tr>
            <tr class="border-b">
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">Tujuan Kunjungan</td>
                <td class="px-3 py-2">{{ $kunjungan->tujuan_kunjungan }}</td>
            </tr>
            <tr class="border-b">
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">Jumlah Pengunjung</td>
                <td class="px-3 py-2">{{ $kunjungan->jumlah_pengunjung }}</td>
            </tr>
            <tr class="border-b">
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">Metode Pembayaran</td>
                <td class="px-3 py-2 uppercase">{{ $kunjungan->payment_method }}</td>
            </tr>
            <tr class="border-b">
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">Status Kunjungan</td>
                <td class="px-3 py-2">
                    <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-bold uppercase text-emerald-800">
                        {{ $kunjungan->status_kunjungan }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">QR Token</td>
                <td class="px-3 py-2 font-mono text-xs break-all">{{ $kunjungan->qr_token }}</td>
            </tr>
            @if($kunjungan->surat_pengajuan)
            <tr>
                <td class="w-48 px-3 py-2 font-semibold text-slate-600">Surat Pengajuan</td>
                <td class="px-3 py-2">
                    <a class="text-blue-600 underline" target="_blank" href="{{ asset('storage/'.$kunjungan->surat_pengajuan) }}">Lihat Dokumen</a>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection